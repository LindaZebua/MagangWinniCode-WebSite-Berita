<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Add Log Facade for error logging

use App\Models\User;
use App\Mail\VerifyEmail; // Ensure this Mailable exists and is correctly configured

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // This method typically displays the login form.
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
        // Validate the incoming login credentials
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate(); // Regenerate session ID to prevent session fixation attacks

            // Check if the user's email is verified
            if ($user->email_verified_at === null) {
                Auth::logout(); // Log out the unverified user immediately
                // Redirect back to login with an error message
                return back()->with('error', 'Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi.');
            }

            // Redirect based on user role after successful login and email verification
            // Ensure the 'role' column exists in your 'users' table and is populated correctly
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard'); // Redirect to admin dashboard
            }

            return redirect()->intended('/dashboard'); // Redirect to regular user dashboard
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email'); // Keep the email input filled
    }

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // This method displays the registration form.
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
        // Validate the incoming registration data
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // Ensure username is unique
            'email' => 'required|string|email|max:255|unique:users,email',   // Ensure email is unique and valid format
            'password' => 'required|string|min:8|confirmed',                 // Password must be at least 8 chars and match confirmation
            'aggree' => 'required|accepted',                                 // Ensure terms and policy checkbox is checked
        ]);

        // If validation fails, redirect back with errors and old input
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Create the new user record in the database
            $user = User::create([
                'name' => $request->username, // Assuming 'name' column in users table stores username. If it's for full name, change to $request->nama_lengkap
                'username' => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash the password for security
                'verification_token' => Str::random(60),     // Generate a unique verification token
                'role' => 'user',                            // Assign a default role for new users
            ]);

            // Prepare the email verification link
            $verificationLink = route('verify.email', ['token' => $user->verification_token]);

            // Send the email verification link to the user
            Mail::to($user->email)->send(new VerifyEmail($user, $verificationLink));

            // Redirect to the login page with a success message after successful registration and email sending
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun.');

        } catch (\Exception $e) {
            // Log the error for debugging purposes (e.g., if email sending fails)
            Log::error('Gagal mengirim email verifikasi ke ' . $request->email . ': ' . $e->getMessage());

            // If user creation succeeded but email sending failed, you might want to delete the user
            // to prevent unverified accounts that cannot be verified. This behavior can be adjusted.
            if (isset($user) && $user->exists()) {
                $user->delete(); // Delete the user if email sending failed
            }

            // Redirect back with an error message if registration or email sending fails
            return back()->with('error', 'Registrasi gagal. Tidak dapat mengirim email verifikasi. Silakan coba lagi nanti.')->withInput();
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
        // Find the user by the verification token
        $user = User::where('verification_token', $token)->first();

        // If no user is found with the given token
        if (!$user) {
            return redirect()->route('login')->with('error', 'Token verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        // If the email is already verified
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Email Anda sudah diverifikasi sebelumnya. Silakan login.');
        }

        // Mark the email as verified
        $user->email_verified_at = now();       // Set the current timestamp for verification
        $user->verification_token = null;       // Clear the verification token
        $user->save();                          // Save the user changes

        Auth::login($user); // Log the user in automatically after successful verification

        // Redirect to the dashboard with a success message
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
        Auth::logout(); // Log out the authenticated user
        $request->session()->invalidate(); // Invalidate the current session
        $request->session()->regenerateToken(); // Regenerate the CSRF token

        // Redirect to the login page with a success message
        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}