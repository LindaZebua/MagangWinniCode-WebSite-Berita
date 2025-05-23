@extends('content.layouts.main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Tambah Komentar</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('comments.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="comment_text">Teks Komentar</label>
                                    <textarea name="comment_text" id="comment_text" class="form-control" required>{{ old('comment_text') }}</textarea>
                                    @error('comment_text')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="news_id">Berita</label>
                                    <select name="news_id" id="news_id" class="form-control" required>
                                        <option value="">-- Pilih Berita --</option>
                                        @foreach($news as $newsItem)
                                            <option value="{{ $newsItem->news_id }}" {{ old('news_id') == $newsItem->news_id ? 'selected' : '' }}>
                                                {{ $newsItem->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('news_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="user_id">Pengguna</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">-- Pilih Pengguna --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="commented_at">Tanggal Komentar (Opsional)</label>
                                    <input type="datetime-local" name="commented_at" id="commented_at" class="form-control" value="{{ old('commented_at') }}">
                                    @error('commented_at')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('comments.index') }}" class="btn btn-secondary">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
