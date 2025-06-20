@extends('frontend.app')

@section('content')
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            {{-- Pastikan $category ada dan memiliki properti category_name --}}
                            <h4 class="m-0 text-uppercase font-weight-bold">Category: {{ $category->category_name ?? 'Unknown Category' }}</h4>
                        </div>
                    </div>
                    @forelse ($newsByCategory as $newsItem)
                        <div class="col-lg-6">
                            <div class="position-relative mb-3">
                                <img class="img-fluid w-100" src="{{ Storage::url('uploads/' . $newsItem->gambar_berita) }}" style="object-fit: cover;">
                                <div class="overlay position-relative bg-white px-3 d-flex flex-column justify-content-center" style="height: 80px;">
                                    <div class="mb-2">
                                        {{-- Gunakan ID kategori untuk rute --}}
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                           href="{{ route('category.news', $newsItem->category->category_id ?? '') }}">
                                           {{ $newsItem->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        {{-- Gunakan news_id untuk route 'news.single' --}}
                                        <a class="text-body" href="{{ route('news.single', $newsItem->news_id) }}">
                                            <small>{{ \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') }}</small>
                                        </a>
                                    </div>
                                    {{-- Gunakan news_id untuk route 'news.single' --}}
                                    <a class="h6 m-0 text-uppercase font-weight-bold" href="{{ route('news.single', $newsItem->news_id) }}">{{ Str::limit($newsItem->title, 70) }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No news found for this category.</p>
                        </div>
                    @endforelse
                    <div class="col-12">
                        {{-- Laravel pagination links --}}
                        {{ $newsByCategory->links() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Memasukkan sidebar --}}
                @include('frontend.sidebar')
            </div>
        </div>
    </div>
@endsection