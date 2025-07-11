<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Media; // Asumsi ada model Media untuk foto galeri
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage; // Tidak digunakan di controller ini, bisa dihapus
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Penting: Pastikan ini ada jika Str::limit() digunakan

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
        // Base query untuk berita yang sudah dipublikasikan
        $baseNewsQuery = News::with(['category', 'user', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at'); // Selalu urutkan dari yang terbaru berdasarkan published_at

        // 1. Berita untuk paginasi (Latest News Section)
        // Ambil 6 berita per halaman untuk pagination
        $latestNewsPaginated = $baseNewsQuery->paginate(6);
        // Mengambil item dari koleksi paginated untuk diiterasi di view utama
        $news = $latestNewsPaginated->items();

        // 2. Berita untuk carousel utama (biasanya berita terbaru pertama)
        $mainCarouselNews = (clone $baseNewsQuery)->take(1)->get(); // Hanya ambil 1 berita

        // 3. Berita samping (4 berita setelah berita utama carousel)
        $sideNews = (clone $baseNewsQuery)->skip(1)->take(4)->get();

        // 4. Berita unggulan untuk carousel (misalnya, paling banyak dilihat)
        $featuredNewsCarousel = News::with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('views') // Contoh: Ambil berita dengan views terbanyak
            ->take(4)
            ->get();

        // 5. Berita populer (terpopuler secara keseluruhan)
        $popularNews = News::with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('views') // Berita populer berdasarkan jumlah views
            ->take(3) // Mengambil 3 berita terpopuler
            ->get();

        // 6. Ambil semua kategori, beserta jumlah berita di setiap kategori
        $categories = Category::withCount(['news' => function ($query) {
                // Hanya hitung berita yang sudah dipublikasikan di setiap kategori
                $query->whereNotNull('published_at')
                      ->where('published_at', '<=', Carbon::now());
            }])
            ->orderBy('category_name')
            ->get();

        // 7. Ambil foto acak dari model Media (untuk bagian seperti "Flickr Photos" di footer/sidebar)
        $flickrPhotos = Media::inRandomOrder()->take(10)->get();

        return view('frontend.app', compact(
            'news',              // Untuk menampilkan daftar berita yang dipaginasi (item saat ini)
            'latestNewsPaginated', // Untuk menampilkan link paginasi (misal: $latestNewsPaginated->links())
            'mainCarouselNews',
            'sideNews',
            'popularNews',
            'categories',
            'flickrPhotos',
            'featuredNewsCarousel'
        ));
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
        // Ambil berita untuk kategori ini, yang sudah dipublikasikan
        $newsByCategory = $category->news()
            ->with(['user', 'media'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at')
            ->paginate(10); // Sesuaikan jumlah item per halaman

        // Ambil kembali semua kategori untuk sidebar/navigasi (dengan hitungan berita yang dipublikasikan)
        $categories = Category::withCount(['news' => function ($query) {
                $query->whereNotNull('published_at')
                      ->where('published_at', '<=', Carbon::now());
            }])
            ->orderBy('category_name')
            ->get();

        // Ambil berita terpopuler untuk sidebar/footer (yang sudah dipublikasikan)
        $popularNews = News::with('category')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->orderByDesc('views')
            ->take(3)
            ->get();

        // Ambil foto acak dari model Media untuk sidebar (disamakan dengan homepage)
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
        // dd($news); // Hapus baris dd() ini dari produksi!

        // Pastikan berita sudah dipublikasikan sebelum ditampilkan
        if (is_null($news->published_at) || $news->published_at > Carbon::now()) {
            abort(404, 'Berita belum dipublikasikan atau tidak ditemukan.');
        }

        // Tingkatkan jumlah tampilan (views) setiap kali berita ini diakses
        $news->increment('views');

        // Eager load relasi yang diperlukan untuk halaman detail berita
        $news->load('media', 'user', 'category');

        // Ambil komentar terkait berita ini, diurutkan dari yang terbaru, dan muat user komentator
        $comments = $news->comments()->with('user')->latest('commented_at')->get(); // Urutkan komentar berdasarkan commented_at

        // Ambil kembali semua kategori untuk sidebar/navigasi (dengan hitungan berita yang dipublikasikan)
        $categories = Category::withCount(['news' => function ($query) {
                $query->whereNotNull('published_at')
                      ->where('published_at', '<=', Carbon::now());
            }])
            ->orderBy('category_name')
            ->get();

        // Ambil berita terpopuler untuk sidebar/footer (yang sudah dipublikasikan)
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
        // $comment->load('user'); // Pastikan ini di-load agar relasi user tersedia

    //$userProfilePhotoUrl = $comment->user->profile_photo_path ? Storage::url('uploads/' . $comment->user->profile_photo_path) : asset('img/user.jpg');
        // Periksa apakah user sudah login di awal untuk keamanan
        if (!Auth::check()) {
            // Untuk AJAX, kembalikan JSON error
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Anda harus login untuk berkomentar.'], 401);
            }
            return back()->with('error', 'Anda harus login untuk berkomentar.');
        }

        // Validasi input komentar
        $validator = \Validator::make($request->all(), [ // Gunakan Facade Validator
            'news_id' => 'required|exists:news,news_id', // Validasi ke news_id
            'comment_text' => 'required|string|max:1000',
        ], [
            'news_id.required' => 'Berita tidak ditemukan.',
            'news_id.exists' => 'Berita tidak valid.',
            'comment_text.required' => 'Komentar tidak boleh kosong.',
            'comment_text.max' => 'Komentar terlalu panjang (maksimal 1000 karakter).',
        ]);

        if ($validator->fails()) {
            // Untuk AJAX, kembalikan JSON error dengan pesan validasi
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()->all()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Buat komentar baru di database
            $comment = Comment::create([
                'news_id' => $request->news_id,
                'user_id' => Auth::id(),
                'comment_text' => $request->comment_text,
                'commented_at' => Carbon::now(),
            ]);

            // Load relasi user untuk komentar yang baru dibuat
            $comment->load('user');

            // Untuk AJAX, kembalikan JSON sukses dengan data komentar
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Komentar Anda berhasil ditambahkan!',
                    'comment' => [
                        'comment_text' => $comment->comment_text,
                        'user_name' => $comment->user->name, // Asumsi user memiliki kolom 'name'
                        'commented_at' => $comment->commented_at->diffForHumans(), // Format waktu yang lebih mudah dibaca
                    ]
                ]);
            }

            // Fallback untuk non-AJAX (jika form tidak dikirim via AJAX)
            $news = News::find($request->news_id);
            if ($news) {
                return redirect()->route('news.single', $news->news_id)->with('success', 'Komentar Anda berhasil ditambahkan!');
            }
            return back()->with('success', 'Komentar Anda berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Tangani error database atau lainnya
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menyimpan komentar: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan saat menyimpan komentar. Silakan coba lagi.');
        }
    }
    /**
     * Menampilkan halaman kontak.
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        // Ambil kategori jika diperlukan untuk navigasi atau sidebar di halaman kontak (dengan hitungan berita yang dipublikasikan)
        $categories = Category::withCount(['news' => function ($query) {
                $query->whereNotNull('published_at')
                      ->where('published_at', '<=', Carbon::now());
            }])
            ->orderBy('category_name')
            ->get();

        // Ambil berita terpopuler untuk sidebar (yang sudah dipublikasikan)
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