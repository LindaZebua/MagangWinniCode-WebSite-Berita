@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Show News</strong>
                        </div>
                        <div class="card-body">
                            <h2>{{ $news->title }}</h2>
                            @if ($news->gambar_berita)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/uploads/' . $news->gambar_berita) }}" alt="{{ $news->title }}" class="img-fluid">
                                </div>
                            @endif
                            <p>{{ $news->content }}</p>
                            <p>Published At: {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->format('Y-m-d H:i:s') : '-' }}</p>
                            <p>Category: {{ $news->category->category_name }}</p>
                            <p>Author: {{ $news->user->name }}</p>
                            <div class="mt-3">
                                <a href="{{ route('news.edit', $news->news_id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('news.destroy', $news->news_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this news?')">Delete</button>
                                </form>
                                <a href="{{ route('news.index') }}" class="btn btn-secondary btn-sm ml-2">Back to List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection