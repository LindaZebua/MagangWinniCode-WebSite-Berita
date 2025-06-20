<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media; // Asumsi ada model Media untuk foto galeri
use Illuminate\Http\Request;
use Illuminate\Support\Carbon; // Digunakan untuk memanipulasi tanggal, seperti now()
use Illuminate\Support\Facades\Storage; // Digunakan untuk Storage::url pada gambar
use Illuminate\Support\Facades\Auth; // Digunakan untuk user_id yang login saat berkomentar
use Illuminate\Support\Str; // Tambahkan ini karena Str::limit() digunakan di Blade

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage) dengan berbagai section berita.
     * Termasuk berita untuk carousel utama, berita samping, berita populer, dan kategori.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil berita terbaru yang sudah dipublikasikan
        // PENTING: Muat relasi 'media' di sini agar bisa diakses di Blade tanpa error.
        $allPublishedNews = News::with(['category', 'user', 'media']) // <-- Tambahkan 'media' di sini
                                ->whereNotNull('published_at')
                                ->where('published_at', '<=', Carbon::now())
                                ->latest('published_at')
                                ->get();

        // 2. Alokasikan berita untuk carousel utama (misal 1 berita paling baru untuk bagian besar)
        $mainCarouselNews = $allPublishedNews->slice(0, 1);

        // 3. Alokasikan berita untuk bagian samping (side sections, misal 4 berita berikutnya)
        $sideNews = $allPublishedNews->slice(1, 4);

        // Perbaiki duplikasi dan pastikan pengambilan 4 berita terbaru untuk Featured News Carousel
        // Ambil 4 berita terbaru untuk carousel "Featured News"
        // Jika Anda ingin ini berbeda dari $sideNews, pastikan logika slice/take-nya sesuai.
        // Untuk saat ini, kita ambil 4 terbaru dari $allPublishedNews.
        $featuredNewsCarousel = $allPublishedNews->take(4); // Menggunakan take(4) yang lebih sederhana

        // 4. Ambil berita terpopuler (misal 3 berita dengan views tertinggi)
        $popularNews = News::with('category')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', Carbon::now())
                            ->orderByDesc('views')
                            ->take(3)
                            ->get();

        // 5. Ambil semua kategori, beserta jumlah berita di setiap kategori
        $categories = Category::withCount('news')
                                ->orderBy('category_name')
                                ->get();

        // 6. Ambil foto acak dari model Media (untuk bagian seperti "Flickr Photos" di footer/sidebar)
        $flickrPhotos = Media::inRandomOrder()->take(10)->get();

        // Kirim semua data ke view 'frontend.home'
        return view('frontend.home', compact('mainCarouselNews', 'sideNews', 'popularNews', 'categories', 'flickrPhotos', 'featuredNewsCarousel'));
    }

    /**
     * Menampilkan daftar berita berdasarkan kategori tertentu.
     * Menggunakan Route Model Binding untuk Category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\View\View
     */
    public function showCategoryNews(Category $category)
    {
        // Ambil berita yang terkait dengan kategori yang diberikan, dengan pagination
        $newsByCategory = $category->news()
                                    ->with(['user', 'media']) // <-- Tambahkan 'media' di sini juga jika diperlukan
                                    ->whereNotNull('published_at')
                                    ->where('published_at', '<=', Carbon::now())
                                    ->latest('published_at')
                                    ->paginate(10); // Sesuaikan jumlah item per halaman

        // Ambil kembali semua kategori untuk sidebar/navigasi
        $categories = Category::withCount('news')->orderBy('category_name')->get();

        // Ambil berita terpopuler untuk sidebar/footer
        $popularNews = News::with('category')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', Carbon::now())
                            ->orderByDesc('views')
                            ->take(3)
                            ->get();

        // Ambil foto acak dari model Media untuk sidebar
        $flickrPhotos = Media::inRandomOrder()->take(10)->get();

        // Kirim data ke view 'frontend.category'
        return view('frontend.category', compact('category', 'newsByCategory', 'categories', 'popularNews', 'flickrPhotos'));
    }

    /**
     * Menampilkan detail berita tunggal.
     * Menggunakan Route Model Binding untuk News.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\View\View
     */
    public function showSingleNews(News $news)
    {
        // Tingkatkan jumlah tampilan (views) setiap kali berita ini diakses
        $news->increment('views');

        // Pastikan relasi 'media' dimuat di sini juga
        $news->load('media'); // <-- Load media untuk berita tunggal ini

        // Ambil komentar terkait berita ini, diurutkan dari yang terbaru, dan muat user komentator
        $comments = $news->comments()->with('user')->latest()->get();

        // Ambil kembali semua kategori untuk sidebar/navigasi
        $categories = Category::withCount('news')->orderBy('category_name')->get();

        // Ambil berita terpopuler untuk sidebar/footer
        $popularNews = News::with('category')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', Carbon::now())
                            ->orderByDesc('views')
                            ->take(3)
                            ->get();

        // Ambil foto acak dari model Media untuk sidebar
        $flickrPhotos = Media::inRandomOrder()->take(6)->get();

        // Kirim data ke view 'frontend.single'
        return view('frontend.single', compact('news', 'comments', 'categories', 'popularNews', 'flickrPhotos'));
    }

    /**
     * Menyimpan komentar yang dikirim dari form di frontend.
     * Memerlukan user yang sudah login untuk bisa berkomentar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeComment(Request $request)
    {
        // Validasi input komentar
        $request->validate([
            'news_id' => 'required|exists:news,news_id', // Pastikan ID berita valid
            'comment_text' => 'required|string|max:1000', // Isi komentar wajib dan maksimal 1000 karakter
        ], [
            'news_id.required' => 'Berita tidak ditemukan.',
            'news_id.exists' => 'Berita tidak valid.',
            'comment_text.required' => 'Komentar tidak boleh kosong.',
            'comment_text.max' => 'Komentar terlalu panjang (maksimal 1000 karakter).',
        ]);

        // Periksa apakah user sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan kembali dengan pesan error
            return back()->with('error', 'Anda harus login untuk berkomentar.');
        }

        // Buat komentar baru di database
        Comment::create([
            'news_id' => $request->news_id,
            'user_id' => Auth::id(), // Dapatkan ID user yang sedang login
            'comment_text' => $request->comment_text,
            'commented_at' => Carbon::now(), // Set waktu komentar saat ini
        ]);

        // Arahkan kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Komentar Anda berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman kontak.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Ambil kategori jika diperlukan untuk navigasi atau sidebar di halaman kontak
        $categories = Category::all();

        // Ambil berita terpopuler untuk sidebar
        $popularNews = News::with('category')
                            ->whereNotNull('published_at')
                            ->where('published_at', '<=', Carbon::now())
                            ->orderByDesc('views')
                            ->take(3)
                            ->get();

        // Ambil foto acak dari model Media untuk sidebar
        $flickrPhotos = Media::inRandomOrder()->take(6)->get();

        return view('frontend.contact', compact('categories', 'popularNews', 'flickrPhotos'));
    }
}