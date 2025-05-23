<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str; // Untuk membuat token acak yang lebih aman
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Memproses verifikasi login
     */
    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Tambahkan pengecekan verifikasi email
            if (Auth::user()->email_verified_at === null) {
                Auth::logout();
                return back()->with('error', 'Akun belum diverifikasi. Silakan cek email Anda untuk verifikasi.');
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Menampilkan halaman registrasi
     */
    public function showRegistrationForm()
    {
         dd('Controller for register page is reached!');
         
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi data registrasi
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username', // Sesuaikan dengan nama input di form
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Simpan data pengguna ke database
        $user = User::create([
            'name' => $request->username, // Kolom 'name' biasanya untuk display name atau username
            'username' => $request->username,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_token' => Str::random(60), // Generate token acak yang lebih aman
        ]);

        if ($user) {
            // Kode PHPMailer di sini
            $mail = new PHPMailer(true);
            try {
                // Konfigurasi SMTP dari config Laravel
                $mail->isSMTP();
                $mail->Host       = config('mail.mailers.smtp.host');
                $mail->SMTPAuth   = config('mail.mailers.smtp.username') ? true : false;
                $mail->Username   = config('mail.mailers.smtp.username');
                $mail->Password   = config('mail.mailers.smtp.password');
                $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
                $mail->Port       = config('mail.mailers.smtp.port');
                $mail->SMTPOptions = array( // Tambahkan ini jika ada masalah dengan SSL/TLS
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

                $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
                $mail->addAddress($user->email, $user->nama_lengkap); // Gunakan nama_lengkap untuk pengiriman email
                $mail->isHTML(true);
                $mail->Subject = 'Verifikasi Akun Anda di Nama Website Anda!';
                $verificationLink = url('/verify-email/' . $user->verification_token); // Buat URL Verifikasi
                $mail->Body       = "Halo " . $user->nama_lengkap . ",<br><br>"
                                  . "Terima kasih telah mendaftar di Nama Website Anda. <br>"
                                  . "Silakan verifikasi email Anda dengan mengklik tautan berikut: <br>"
                                  . "<a href='" . $verificationLink . "'>" . $verificationLink . "</a><br><br>"
                                  . "Jika Anda tidak mendaftar di situs ini, abaikan email ini.<br><br>"
                                  . "Terima kasih,<br>"
                                  . "Tim Nama Website Anda";
                $mail->AltBody = "Terima kasih telah mendaftar di Nama Website Anda. Silakan verifikasi email Anda dengan mengunjungi tautan berikut: " . $verificationLink;

                $mail->send();
                return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan cek email Anda untuk verifikasi akun.');
            } catch (Exception $e) {
                // Hapus user jika email gagal terkirim dan tidak ada verifikasi
                $user->delete(); // Atau set status sebagai 'unverified'
                return back()->with('error', 'Registrasi gagal. Gagal mengirim email verifikasi: ' . $mail->ErrorInfo)->withInput();
            }
        }

        // Handle jika registrasi gagal menyimpan ke database (jarang terjadi jika validasi lolos)
        return back()->with('error', 'Gagal melakukan registrasi.')->withInput();
         
    }

    /**
     * Menangani proses verifikasi email dari tautan
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

        $user->email_verified_at = now(); // Set timestamp saat ini
        $user->verification_token = null; // Hapus token setelah verifikasi
        $user->save();

        Auth::login($user); // Log user in setelah verifikasi berhasil

        return redirect()->intended('/dashboard')->with('success', 'Email Anda berhasil diverifikasi! Anda sekarang sudah login.');
    }


    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }
}