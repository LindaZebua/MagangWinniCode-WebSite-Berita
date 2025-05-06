@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Edit Berita</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('news.update', $news->news_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="title">Judul</label>
                                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $news->title }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="content">Konten</label>
                                    <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" required>{{ $news->content }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="published_at">Tanggal Terbit</label>
                                    <input type="datetime-local" id="published_at" name="published_at" class="form-control @error('published_at') is-invalid @enderror" value="{{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d\TH:i') : '' }}">
                                    @error('published_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="category_id">Kategori</label>
                                    <select id="category_id" name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->category_id }}" {{ $news->category_id == $category->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="user_id">Pengguna</label>
                                    <select id="user_id" name="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $news->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="gambar_berita">Gambar Saat Ini</label>
                                    @if ($news->gambar_berita)
                                        <img src="{{ asset('storage/' . $news->gambar_berita) }}" alt="{{ $news->title }}" class="img-thumbnail" width="150">
                                    @else
                                        <p>Tidak ada gambar diunggah.</p>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="gambar_berita">Unggah Gambar Baru (Opsional)</label>
                                    <input type="file" id="gambar_berita" name="gambar_berita" class="form-control-file @error('gambar_berita') is-invalid @enderror">
                                    @error('gambar_berita')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar saat ini.</small>
                                </div>

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                                <a href="{{ route('news.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection