<?php

namespace App\Http\Controllers;

use App\Models\Category; // Menggunakan Category
use App\Models\News;     // Menggunakan News
use Illuminate\Http\Request; // Menggunakan Request jika ada method yang memerlukannya

class HomeController extends Controller
{
    public function index()
    {

        $featuredNews = News::latest()->take(3)->get();
        $categories = Category::all();
        $latestNews = News::latest()->paginate(6);
        $popularNews = News::orderBy('views', 'desc')->take(5)->get();
        $popularCategories = Category::withCount('news')
            ->orderBy('news_count', 'desc')
            ->take(5)
            ->get();

        return view('frontend.welcome', compact('featuredNews', 'categories', 'latestNews', 'popularNews', 'popularCategories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $news = $category->news()->latest()->paginate(10); // Ambil berita terkait kategori
        $categories = Category::all(); // Untuk navigasi atau sidebar
        return view('frontend.categories', compact('category', 'news', 'categories'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)->with(['user', 'category', 'comments.user'])->firstOrFail();
        $news->increment('views'); // Pastikan ada kolom 'views' di tabel news

        $categories = Category::all(); // Untuk navigasi atau sidebar
        $latestNews = News::latest()->take(5)->get(); // Berita terkait atau terbaru di sidebar

        return view('frontend.show', compact('news', 'categories', 'latestNews'));
    }
}