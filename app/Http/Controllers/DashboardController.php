<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $news = News::with(['user', 'category', 'comments'])->latest()->paginate(10);

        $newsCount = News::count();
        $categoriesCount = Category::count();
        $usersCount = User::count();
        $commentsCount = Comment::count();
        $mediaCount = Media::count();
        $users = User::all(); // Ini sudah benar jika Anda ingin semua user
        $media = Media::all(); // Ini sudah benar jika Anda ingin semua media (tanpa pagination)

        return view("content.dashboard.index", compact(
            'media',
            'news', // Sekarang ini adalah objek paginator
            'newsCount',
            'categoriesCount',
            'usersCount',
            'commentsCount',
            'mediaCount',
            'users'
        ));
    }

    public function profile()
    {
        $user = Auth::user();

        if ($user) {
            return view('content.profile', compact('user'));
        } else {
            return redirect('/login');
        }
    }

    public function resetPassword()
    {
        return view('content.resetPassword');
    }
}
