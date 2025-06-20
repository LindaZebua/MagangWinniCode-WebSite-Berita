{{-- resources/views/frontend/single.blade.php --}}

@extends('frontend.app')

@section('content')

    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="position-relative mb-3">
                    {{-- Pastikan 'gambar_berita' adalah nama kolom di database Anda --}}
                    {{-- Pastikan 'uploads' adalah folder di public/storage --}}
                    <img class="img-fluid w-100" src="{{ Storage::url('uploads/' . $news->gambar_berita) }}" style="object-fit: cover;">
                    <div class="overlay position-relative bg-white px-3 pt-2">
                        <div class="mb-3">
                            {{-- Gunakan ID kategori untuk rute --}}
                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                href="{{ route('category.news', $news->category->category_id) }}">{{ $news->category->category_name ?? 'Uncategorized' }}</a>
                            <a class="text-body" href="{{ route('news.single', $news->news_id) }}"><small>{{ \Carbon\Carbon::parse($news->published_at)->format('M d, Y') }}</small></a>
                        </div>
                        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold">{{ $news->title }}</h1>
                        {{-- Menggunakan {!! !!} untuk render HTML jika konten Anda memang ada tag HTML --}}
                        {{-- HATI-HATI dengan XSS jika kontennya dari input user --}}
                        <p>{!! $news->content !!}</p>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                            <div class="d-flex align-items-center">
                                @if($news->user && $news->user->profile_photo_path)
                                <img class="rounded-circle mr-2" src="{{ Storage::url('uploads/' . $news->user->profile_photo_path) }}" width="25" height="25" alt="Author Photo">
                                @endif
                                <span>{{ $news->user->name ?? 'Unknown' }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="ml-3"><i class="far fa-eye mr-2"></i>{{ $news->views ?? 0 }}</span>
                                <span class="ml-3"><i class="far fa-comments mr-2"></i>{{ $comments->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">{{ $comments->count() }} Comments</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        @forelse ($comments as $comment)
                            <div class="media mb-4">
                                @if($comment->user && $comment->user->profile_photo_path)
                                <img src="{{ Storage::url('uploads/' . $comment->user->profile_photo_path) }}" alt="User Photo" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                @endif
                                <div class="media-body">
                                    <h6><a class="text-secondary font-weight-bold" href="">{{ $comment->user->name ?? 'Anonymous' }}</a> <small><i>{{ $comment->commented_at->diffForHumans() }}</i></small></h6>
                                    <p>{{ $comment->comment_text }}</p>
                                </div>
                            </div>
                        @empty
                            <p>No comments yet. Be the first to comment!</p>
                        @endforelse
                    </div>
                </div>

                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Leave a Comment</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-4">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="news_id" value="{{ $news->news_id }}">
                            <div class="form-group">
                                <label for="message">Message *</label>
                                <textarea id="message" cols="30" rows="5" class="form-control" name="comment_text" required></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Leave a Comment"
                                    class="btn btn-primary font-weight-semi-bold py-2 px-3">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Placeholder untuk konten sidebar khusus halaman berita tunggal --}}
                @include('frontend.sidebar')
            </div>
        </div>
    </div>
@endsection