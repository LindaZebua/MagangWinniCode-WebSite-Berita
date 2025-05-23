<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
class CommentController extends Controller
{
    /**
     * Display a listing of the comments.
     */
    public function index()
    {
        $comments = Comment::with(['news', 'user'])->latest()->paginate(10);
        return view('content.comments.index', compact('comments'));
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
        $validatedData = $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|exists:news,news_id',
            'user_id' => 'required|exists:users,id',
            'commented_at' => 'nullable|date',
        ]);

        $commented_at = $validatedData['commented_at']
            ? Carbon::parse($validatedData['commented_at'])
            : Carbon::now();

        Comment::create([
            'comment_text' => $validatedData['comment_text'],
            'news_id' => $validatedData['news_id'],
            'user_id' => $validatedData['user_id'],
            'commented_at' => $commented_at,
        ]);

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil ditambahkan.'); // Diubah dari 'comment.index' menjadi 'comments.index'
    }

    /**
     * Display the specified comment.  (Not used in your provided views, but good to have)
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
            : $comment->commented_at;

        $comment->update([
            'comment_text' => $validatedData['comment_text'],
            'news_id' => $validatedData['news_id'],
            'user_id' => $validatedData['user_id'],
            'commented_at' => $commented_at,
        ]);

        return redirect()->route('comments.index')->with('success', 'Komentar berhasil diperbarui.'); // Diubah dari 'comment.index' menjadi 'comments.index'
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comment.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
