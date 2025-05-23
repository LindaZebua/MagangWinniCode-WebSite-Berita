<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\Category; // Tambahkan model Category jika diperlukan
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        return view("content.layouts.main", compact("usersCount"));
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

    public function home() {
        $usersCount = User::count();
        $totalBerita = News::count();
        $beritaHariIni = News::whereDate('created_at', today())->count();
        $beritaMingguIni = News::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $kategoriTerbanyak = Category::withCount('news')
            ->orderByDesc('news_count')
            ->first();

        return view('content.layouts.home', compact(
            'usersCount',
            'totalBerita',
            'beritaHariIni',
            'beritaMingguIni',
            'kategoriTerbanyak'
        ));
    }

    public function resetPassword()
    {
        return view('content.resetPassword');
    }
}