<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        return view("content.layouts.main", compact("usersCount"));
    }

    public function profile()
    {
        // Use Auth::guard() to specify the guard, and ensure user() is called on the guard.
        $user = Auth::guard('user')->user();

        // Check if a user is authenticated before trying to access their ID.
        if ($user) {
            $id = $user->id;
             $user = User::findOrFail($id); //findOrFail akan otomatis menampilkan error jika $id tidak ditemukan
            return view('backend.content.profile', compact('user'));
        } else {
            // Handle the case where no user is authenticated with the specified guard.
            // You might want to redirect to the login page or show an error message.
            return redirect()->route('login')->with('error', 'Please log in to view your profile.'); // Contoh: Redirect ke halaman login
        }
    }
}
