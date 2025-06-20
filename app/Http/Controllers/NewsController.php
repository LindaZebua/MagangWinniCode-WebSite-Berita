<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Comment; // Pastikan model Comment ada dan diimpor
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Tambahkan ini untuk Str::slug

class NewsController extends Controller
{

    public function index()
    {
        $users = User::all();
        $news = News::with(['user', 'category', 'comments'])->latest()->get();
        $popularNews = News::with(['user', 'category', 'comments'])->orderByDesc('views')->take(5)->get();
        $newsCount = News::count();
        return view('content.news.index', compact('news', 'newsCount', 'popularNews','users'));
    }

    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('content.news.create', compact('categories', 'users'));
    }

    public function store(Request $request)
    {
        // Debugging: Lihat semua data yang diterima dari request
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,category_id',
            'user_id' => 'required|exists:users,id',
            'gambar_berita' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048', // Tambah webp, perbesar max size jika perlu
        ]);

        try {
            $news = new News();
            $news->title = $request->title;
            // Generate slug dari title jika Anda tidak punya input slug di form
            $news->slug = Str::slug($request->title); // PENTING: Tambahkan ini
            $news->content = $request->content;
            $news->published_at = $request->published_at;
            $news->category_id = $request->category_id;
            $news->user_id = $request->user_id;
            $news->views = 0; 
            if ($request->hasFile('gambar_berita')) {
                // Pastikan folder 'uploads' di dalam 'storage/app/public' ada dan writeable
                $path = $request->file('gambar_berita')->store('uploads', 'public');
                $news->gambar_berita = basename($path);
            } else {
                $news->gambar_berita = null; // Pastikan default value jika tidak ada gambar, jika kolom bisa NULL
            }

            $news->save(); // Mencoba menyimpan model ke database

            return redirect()->route('news.index')->with('success', 'News created successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Ini akan menangkap error dari database, seperti kolom NOT NULL yang kosong
            return redirect()->back()->withInput()->with('error', 'Database Error: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Ini akan menangkap error umum lainnya
            return redirect()->back()->withInput()->with('error', 'An error occurred: ' . $e->getMessage());
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
            'gambar_berita' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            $news->title = $request->title;
            $news->slug = Str::slug($request->title); // PENTING: Pastikan slug di-update juga
            $news->content = $request->content;
            $news->published_at = $request->published_at;
            $news->category_id = $request->category_id;
            $news->user_id = $request->user_id;

            if ($request->hasFile('gambar_berita')) {
                // Hapus gambar lama jika ada
                if ($news->gambar_berita && \Storage::disk('public')->exists('uploads/' . $news->gambar_berita)) {
                    \Storage::disk('public')->delete('uploads/' . $news->gambar_berita);
                }
                $path = $request->file('gambar_berita')->store('uploads', 'public');
                $news->gambar_berita = basename($path);
            }

            $news->save();

            return redirect()->route('news.index')->with('success', 'News updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update news: ' . $e->getMessage());
        }
    }

    public function destroy(News $news)
    {
        try {
            // Hapus gambar terkait sebelum menghapus berita
            if ($news->gambar_berita && \Storage::disk('public')->exists('uploads/' . $news->gambar_berita)) {
                \Storage::disk('public')->delete('uploads/' . $news->gambar_berita);
            }
            $news->delete();
            return redirect()->route('news.index')->with('success', 'News deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('news.index')->with('error', 'Failed to delete news: ' . $e->getMessage());
        }
    }
}