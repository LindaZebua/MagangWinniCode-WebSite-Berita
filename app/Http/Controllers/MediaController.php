<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    /**
     * Display a listing of the media.
     */
    public function index()
    {
        $media = Media::with('news')->latest()->paginate(10);
        return view('content.media.index', compact('media'));
    }

    /**
     * Show the form for creating a new media.
     */
    public function create()
    {
        $news = News::all();
        return view('content.media.create', compact('news'));
    }

    /**
     * Store a newly created media in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:2048', // Contoh validasi ukuran file
            'news_id' => 'required|exists:news,news_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/media', $filename); // Simpan di storage/app/public/media

            Media::create([
                'file_path' => 'media/' . $filename, // Simpan path relatif
                'file_type' => $file->getClientMimeType(),
                'news_id' => $request->news_id,
            ]);

            return redirect()->route('media.index')->with('success', 'Media berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal mengupload file.');
    }

    /**
     * Display the specified media.
     */
    public function show(Media $media)
    {
        return view('content.media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified media.
     */
    public function edit(Media $media)
    {
        $news = News::all();
        return view('content.media.edit', compact('media', 'news'));
    }

    /**
     * Update the specified media in storage.
     */
    public function update(Request $request, Media $media)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'nullable|file|max:2048',
            'news_id' => 'required|exists:news,news_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($media->file_path) {
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
            $media->update([
                'news_id' => $request->news_id,
            ]);
        }

        return redirect()->route('media.index')->with('success', 'Media berhasil diperbarui.');
    }

    /**
     * Remove the specified media from storage.
     */
    public function destroy(Media $media)
    {
        // Hapus file dari storage
        if ($media->file_path) {
            Storage::delete('public/' . $media->file_path);
        }

        $media->delete();
        return redirect()->route('media.index')->with('success', 'Media berhasil dihapus.');
    }
}