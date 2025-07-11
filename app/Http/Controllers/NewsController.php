<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Dipertahankan, meskipun tidak langsung digunakan di controller ini, mungkin digunakan di model atau tempat lain
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; // Import untuk menangani ValidationException secara eksplisit
use Illuminate\Database\QueryException; // Tambahkan import ini untuk menangani QueryException

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua user (jika diperlukan di view, seperti untuk filter atau display)
        $users = User::all();
        // Eager load relasi 'user' dan 'category' untuk menghindari N+1 query problem
        $news = News::with(['user', 'category'])->latest()->get();
        // Ambil 15 berita paling populer berdasarkan jumlah views
        $popularNews = News::with(['user', 'category'])->orderByDesc('views')->take(15)->get();
        // Hitung total berita
        $newsCount = News::count();

        // Kirim data ke view
        return view('content.news.index', compact('news', 'newsCount', 'popularNews', 'users'));
    }

    /**
     * Show the form for creating a new news.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Ambil semua kategori dan user untuk dropdown di form
        $categories = Category::all();
        $users = User::all();

        return view('content.news.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created news in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Validasi input dari request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'published_at' => 'nullable|date',
                // Pastikan 'category_id' ada di tabel 'categories' dan merujuk ke primary key 'category_id'
                'category_id' => 'required|exists:categories,category_id',
                // Pastikan 'user_id' ada di tabel 'users' dan merujuk ke primary key 'id'
                // Jika primary key User Anda juga 'user_id', ubah 'id' menjadi 'user_id'
                'user_id' => 'required|exists:users,id',
                'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Validasi file gambar
            ]);

            $news = new News();
            $news->title = $validatedData['title'];
            $news->content = $validatedData['content'];
            $news->published_at = $validatedData['published_at'];
            $news->category_id = $validatedData['category_id'];
            $news->user_id = $validatedData['user_id'];
            $news->views = 0; // Inisialisasi views

            // Handle file upload
            if ($request->hasFile('gambar_berita')) {
                $file = $request->file('gambar_berita');
                // Simpan file ke direktori 'uploads' di disk 'public'
                $path = $file->store('uploads', 'public');
                // Simpan hanya nama file (tanpa path direktori) ke database
                $news->gambar_berita = basename($path);
            } else {
                $news->gambar_berita = null; // Set null jika tidak ada gambar diupload
            }

            $news->save(); // Simpan data berita ke database

            return redirect()->route('news.index')->with('success', 'Berita berhasil dibuat.');

        } catch (ValidationException $e) {
            // Tangani error validasi (Laravel akan otomatis kembali dengan errors dan old input)
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) { // Gunakan QueryException secara eksplisit
            // Tangani error terkait database (misalnya, masalah koneksi, kolom tidak cocok, foreign key constraint)
            // Log error untuk debugging lebih lanjut
            \Log::error('Kesalahan Database saat membuat berita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Kesalahan Database: Mohon coba lagi atau hubungi dukungan.');
        } catch (\Exception $e) {
            // Tangani error umum lainnya (misalnya, masalah saat upload file)
            // Log error untuk debugging lebih lanjut
            \Log::error('Terjadi kesalahan tak terduga saat membuat berita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan tak terduga: Mohon coba lagi.');
        }
    }

    /**
     * Display the specified news.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\View\View
     */
    public function show(News $news)
    {
        // Eager load relasi yang diperlukan untuk halaman detail berita
        // Memuat user dari komentar juga
        $news->load(['user', 'category', 'comments.user']);
        $news->increment('views'); // Menambah jumlah views setiap kali berita dilihat
        return view('content.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\View\View
     */
    public function edit(News $news)
    {
        // Ambil semua kategori dan user untuk dropdown di form edit
        $categories = Category::all();
        $users = User::all();
        // Kirim data berita yang akan diedit, kategori, dan user ke view
        return view('content.news.edit', compact('news', 'categories', 'users'));
    }

    /**
     * Update the specified news in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, News $news)
    {
        try {
            // Validasi input dari request
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'published_at' => 'nullable|date',
                // Pastikan 'category_id' ada di tabel 'categories' dan merujuk ke primary key 'category_id'
                'category_id' => 'required|exists:categories,category_id',
                // Pastikan 'user_id' ada di tabel 'users' dan merujuk ke primary key 'id'
                // Jika primary key User Anda juga 'user_id', ubah 'id' menjadi 'user_id'
                'user_id' => 'required|exists:users,id',
                'gambar_berita' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Diubah dari 'file' ke 'image'
            ]);

            $news->title = $validatedData['title'];
            // Slug akan otomatis diperbarui oleh mutator setTitleAttribute di model News (jika ada)
            $news->content = $validatedData['content'];
            $news->published_at = $validatedData['published_at'];
            $news->category_id = $validatedData['category_id'];
            $news->user_id = $validatedData['user_id'];

            // Handle file upload untuk update
            if ($request->hasFile('gambar_berita')) {
                // Hapus gambar lama jika ada dan file-nya eksis
                if ($news->gambar_berita && Storage::disk('public')->exists('uploads/' . $news->gambar_berita)) {
                    Storage::disk('public')->delete('uploads/' . $news->gambar_berita);
                }
                // Simpan gambar baru
                $path = $request->file('gambar_berita')->store('uploads', 'public');
                $news->gambar_berita = basename($path);
            }
            // Tambahkan bagian ini jika Anda ingin menghapus gambar_berita jika tidak ada file baru yang diunggah
            // dan input 'gambar_berita' ada tapi kosong (misal checkbox "hapus gambar")
            // if ($request->has('remove_gambar_berita') && $request->input('remove_gambar_berita') == 'true') {
            //     if ($news->gambar_berita && Storage::disk('public')->exists('uploads/' . $news->gambar_berita)) {
            //         Storage::disk('public')->delete('uploads/' . $news->gambar_berita);
            //     }
            //     $news->gambar_berita = null;
            // }


            $news->save(); // Simpan perubahan

            return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan tak terduga saat memperbarui berita: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui berita: Terjadi kesalahan tak terduga. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified news from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(News $news)
    {
        try {
            // Hapus gambar terkait sebelum menghapus berita dari database
            if ($news->gambar_berita && Storage::disk('public')->exists('uploads/' . $news->gambar_berita)) {
                Storage::disk('public')->delete('uploads/' . $news->gambar_berita);
            }
            $news->delete(); // Hapus berita dari database
            return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Terjadi kesalahan tak terduga saat menghapus berita: ' . $e->getMessage());
            return redirect()->route('news.index')->with('error', 'Gagal menghapus berita: Terjadi kesalahan tak terduga. ' . $e->getMessage());
        }
    }
}