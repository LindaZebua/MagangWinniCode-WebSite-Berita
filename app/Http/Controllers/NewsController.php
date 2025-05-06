<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::with(['user', 'category'])->get();
        return view('content.news.index', compact('news')); // Perubahan di sini
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('content.news.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,category_id',
            'user_id' => 'required|exists:users,id',
            'gambar_berita' => 'nullable|file|mimes:jpeg,png,jpg,gif', // Gambar opsional
        ]);

        $news = new News();
        $news->title = $request->title;
        $news->content = $request->content;
        $news->published_at = $request->published_at;
        $news->category_id = $request->category_id;
        $news->user_id = $request->user_id;

        if ($request->hasFile('gambar_berita')) {
            $path = $request->file('gambar_berita')->store('uploads', 'public');
            $news->gambar_berita = basename($path);
        }

        try {
            $news->save();
            return redirect()->route('news.index')->with('success', 'News created successfully.');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Ditambahkan di sini
            return redirect()->route('news.index')->with('error', 'Failed to create news.');
        }
    }

    public function show(News $news)
    {
        return view('content.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        $users = User::all();
        return view('content.news.edit', compact('news', 'categories', 'users'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,category_id',
            'user_id' => 'required|exists:users,id',
            'gambar_berita' => 'nullable|file|mimes:jpeg,png,jpg,gif', // Gambar opsional
        ]);

        $news->title = $request->title;
        $news->content = $request->content;
        $news->published_at = $request->published_at;
        $news->category_id = $request->category_id;
        $news->user_id = $request->user_id;

        if ($request->hasFile('gambar_berita')) {
            $path = $request->file('gambar_berita')->store('uploads', 'public');
            $news->gambar_berita = basename($path);
        }

        try {
            $news->save();
            return redirect()->route('news.index')->with('success', 'News updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('news.index')->with('error', 'Failed to update news.');
        }
    }

    public function destroy(News $news)
    {
        try {
            $news->delete();
            return redirect()->route('news.index')->with('success', 'News deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('news.index')->with('error', 'Failed to delete news.');
        }
    }
}