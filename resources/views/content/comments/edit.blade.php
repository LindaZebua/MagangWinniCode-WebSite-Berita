@extends('content.layouts.main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h2>Edit Komentar</h2>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="comment_text">Teks Komentar</label>
                                    <textarea name="comment_text" id="comment_text" class="form-control" required>{{ old('comment_text', $comment->comment_text) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="news_id">Berita</label>
                                    <select name="news_id" id="news_id" class="form-control" required>
                                        <option value="">Pilih Berita</option>
                                        @foreach($news as $newsItem)
                                            <option value="{{ $newsItem->news_id }}" {{ $comment->news_id == $newsItem->news_id ? 'selected' : '' }}>
                                                {{ $newsItem->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="user_id">Pengguna</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">Pilih Pengguna</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ $comment->user_id == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success">Perbarui</button>
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
