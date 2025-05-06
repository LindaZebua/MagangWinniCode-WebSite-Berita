@extends('content/layouts/main')

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
                                    <textarea name="comment_text" id="comment_text" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="news_id">Berita</label>
                                    <select name="news_id" id="news_id" class="form-control" required>
                                        <option value="">Pilih Berita</option>
                                        @foreach($news as $newsItem)
                                            <option value="{{ $newsItem->id }}">{{ $newsItem->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="user_id">Pengguna</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">Pilih Pengguna</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="{{ route('comment.index') }}" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection