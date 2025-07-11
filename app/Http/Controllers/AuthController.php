<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Mail\VerifyEmail;

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            if ($user->email_verified_at === null) {
                Auth::logout();
                return back()->with('error', 'Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi.');
            }

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'aggree' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->username,
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Tandai langsung terverifikasi
                'verification_token' => null, // Hapus token verifikasi karena sudah langsung terverifikasi
                'role' => 'user',
            ]);

            // Opsional: Anda bisa tetap mengirim email selamat datang atau informasi lain,
            // tetapi HAPUS pengiriman email verifikasi.
            // Contoh (jika Anda ingin mengirim email tapi bukan untuk verifikasi):
            // Mail::to($user->email)->send(new WelcomeEmail($user));

            // Langsung login setelah registrasi
            Auth::login($user);

            // Arahkan ke dashboard berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Registrasi berhasil! Anda telah berhasil login sebagai Admin.');
            }
            return redirect()->intended('/dashboard')->with('success', 'Registrasi berhasil! Anda telah berhasil login.');

        } catch (\Exception $e) {
            Log::error('Registrasi gagal untuk ' . $request->email . ': ' . $e->getMessage());

            // Jika terjadi error saat menyimpan ke database, hapus user yang mungkin setengah jadi
            if (isset($user) && $user->exists()) {
                $user->delete();
            }

            return back()->with('error', 'Registrasi gagal. Silakan coba lagi nanti.')->withInput();
        }
    }
    /**
     * Handle the email verification process from a link.
     *
     * @param  string  $token The verification token from the URL
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleVerification($token)
    {
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Token verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email Anda sudah diverifikasi sebelumnya. Silakan login.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        Auth::login($user);

        return redirect()->intended('/dashboard')->with('success', 'Email Anda berhasil diverifikasi! Anda sekarang sudah login.');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}