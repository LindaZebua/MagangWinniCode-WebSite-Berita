<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $users = User::all();
        $comments = Comment::with(['news', 'user'])->latest()->paginate(10);
        return view('content.comments.index', compact('comments', 'users'));
    }

    /**
     * Show the form for creating a new comment.
     */
    public function create()
    {
        $news = News::all();
        $users = User::all();
        return view('content.comments.create', compact('news', 'users'));
    }

    /**
     * Store a newly created comment in storage.
     */
  public function store(Request $request)
    {
        // Pastikan user sudah login di awal untuk keamanan
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Anda harus login untuk berkomentar.');
        }

        $validatedData = $request->validate([
            'comment_text' => 'required|string|max:1000', // Ditambahkan max length
            'news_id' => 'required|exists:news,news_id', // Pastikan validasi ke news_id
        ]);

        $news = News::find($validatedData['news_id']);
        if (!$news) {
            return redirect()->back()->with('error', 'Artikel berita tidak ditemukan.');
        }

        Comment::create([
            'comment_text' => $validatedData['comment_text'],
            'news_id' => $validatedData['news_id'],
            'user_id' => Auth::id(), // Gunakan ID pengguna yang sedang login
            'commented_at' => Carbon::now(), // Otomatis mengatur waktu saat ini
        ]);

        // Redirect kembali ke halaman berita tunggal setelah komentar berhasil
        // Menggunakan slug jika tersedia, jika tidak kembali ke news_id
        return redirect()->route('news.single', $news->slug ?? $news->news_id)->with('success', 'Komentar Anda berhasil ditambahkan!');
    }

    /**
     * Display the specified comment. (Not used in your provided views, but good to have)
     */
    public function show(Comment $comment)
    {
        return view('content.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        $news = News::all();
        $users = User::all();
        return view('content.comments.edit', compact('comment', 'news', 'users'));
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|exists:news,news_id',
            'user_id' => 'required|exists:users,id',
            'commented_at' => 'nullable|date',
        ]);

        $commented_at = $validatedData['commented_at']
            ? Carbon::parse($validatedData['commented_at'])
            : $comment->commented_at; // Preserve existing commented_at if not provided

        $comment->update([
            'comment_text' => $validatedData['comment_text'],
            'news_id' => $validatedData['news_id'],
            'user_id' => $validatedData['user_id'],
            'commented_at' => $commented_at,
        ]);

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        // Changed from 'comments.index' to 'comments.index' for consistency
        return redirect()->route('comments.index')->with('success', 'Komentar berhasil dihapus.');
    }
}