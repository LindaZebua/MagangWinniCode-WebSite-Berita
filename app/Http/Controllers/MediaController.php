<?php // This must be the very first line, no characters before it, not even comments or blank lines

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\News;
use App\Models\Category; // Tambahkan jika belum ada, meskipun tidak digunakan langsung di controller ini
use App\Models\User;     // Tambahkan jika belum ada
use App\Models\Comment;  // Tambahkan jika belum ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Exception; // Tambahkan ini untuk menangkap Exception

class MediaController extends Controller
{

    public function index()
    {
        $media = Media::with('news')->latest()->paginate(10);
        $berita = News::all(); // Ini mungkin tidak terpakai langsung di view index media, tapi tidak masalah
        $users = User::all();   // Ini juga
        $mediaCount = Media::count();
        return view('content.media.index', compact('media','mediaCount', 'berita','users'));
    }

    /**
     * Menampilkan form untuk membuat media baru.
     */
    public function create()
    {
        $news = News::all();
        return view('content.media.create', compact('news'));
    }

    /**
     * Menyimpan media baru yang dibuat ke dalam penyimpanan.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:2048', // PDF juga diperbolehkan
            'news_id' => 'required|exists:news,news_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validasi gagal. Silakan periksa format dan ukuran file.');
        }

        try {
            $file = $request->file('file');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            // Menyimpan file ke storage/app/public/media
            $path = $file->storeAs('public/media', $namaFile);

            // Membuat entri di database dengan path yang benar
            $media = new Media();
            $media->file_path = 'media/' . $namaFile; // Ini akan menjadi 'media/timestamp_namafile.ext'
            $media->file_type = $file->getClientMimeType();
            $media->news_id = $request->news_id;
            $media->save();

            return redirect()->route('media.index')->with('success', 'Media berhasil ditambahkan.');

        } catch (Exception $e) {
            // Jika terjadi kesalahan saat menyimpan file atau data ke DB
            // Anda bisa log error untuk debugging lebih lanjut
            \Log::error('Gagal menyimpan media: ' . $e->getMessage());
            // Hapus file jika sudah terlanjur tersimpan di storage tapi gagal di DB
            if (isset($path) && Storage::exists($path)) {
                Storage::delete($path);
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan media: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan media yang ditentukan.
     */
    public function show(Media $media)
    {
        return view('content.media.show', compact('media'));
    }

    /**
     * Menampilkan form untuk mengedit media yang ditentukan.
     */
    public function edit(Media $media)
    {
        $news = News::all();
        return view('content.media.edit', compact('media', 'news'));
    }

    /**
     * Memperbarui media yang ditentukan dalam penyimpanan.
     */
    public function update(Request $request, Media $media)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // PDF juga diperbolehkan
            'news_id' => 'required|exists:news,news_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validasi gagal. Silakan periksa format dan ukuran file.');
        }

        try {
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($media->file_path && Storage::exists('public/' . $media->file_path)) {
                    Storage::delete('public/' . $media->file_path);
                }

                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('public/media', $filename);

                $media->update([
                    'file_path' => 'media/' . $filename,
                    'file_type' => $file->getClientMimeType(),
                    'news_id' => $request->news_id,
                ]);
            } else {
                // Jika tidak ada file baru diupload, hanya update news_id
                $media->update([
                    'news_id' => $request->news_id,
                ]);
            }

            return redirect()->route('media.index')->with('success', 'Media berhasil diperbarui.');

        } catch (Exception $e) {
            \Log::error('Gagal memperbarui media: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui media: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus media yang ditentukan dari penyimpanan.
     */
    public function destroy(Media $media)
    {
        try {
            if ($media->file_path && Storage::exists('public/' . $media->file_path)) {
                Storage::delete('public/' . $media->file_path);
            }

            $media->delete();
            return redirect()->route('media.index')->with('success', 'Media berhasil dihapus.');

        } catch (Exception $e) {
            \Log::error('Gagal menghapus media: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus media: ' . $e->getMessage());
        }
    }
}