<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

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
        $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|exists:news,id', // Gunakan 'id' di sini
            'user_id' => 'required|exists:users,id',
            'commented_at' => 'nullable|date',
        ]);
    
        Comment::create($request->all());
    
        return redirect()->route('comment.index')->with('success', 'Komentar berhasil ditambahkan.');
    }

    /**
     * Display the specified comment.
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
        $request->validate([
            'comment_text' => 'required|string',
            'news_id' => 'required|exists:news,id', // Gunakan 'id' di sini
            'user_id' => 'required|exists:users,id',
            'commented_at' => 'nullable|date',
        ]);
    
        $comment->update($request->all());
    
        return redirect()->route('comment.index')->with('success', 'Komentar berhasil diperbarui.');
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