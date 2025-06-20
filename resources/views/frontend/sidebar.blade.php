{{-- resources/views/frontend/sidebar.blade.php --}}

{{-- Ini adalah partial view, jadi tidak memerlukan @extends atau @section --}}

<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Popular News</h5>
    @if(isset($popularNews) && $popularNews->count() > 0) {{-- Tambah cek count() --}}
        @foreach ($popularNews as $newsItem)
            <div class="mb-3">
                <div class="mb-2">
                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                       href="{{ route('category.news', $newsItem->category->category_id ?? '') }}">
                       {{ $newsItem->category->category_name ?? 'Uncategorized' }}
                    </a>
                    <a class="text-body" href="{{ route('news.single', $newsItem->news_id) }}">
                       <small>{{ \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') }}</small>
                    </a>
                </div>
                <a class="small text-body text-uppercase font-weight-medium" href="{{ route('news.single', $newsItem->news_id) }}">
                    {{ Str::limit($newsItem->title, 50) }}
                </a>
            </div>
        @endforeach
    @else
        <p>No popular news available.</p>
    @endif
</div>

<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Categories</h5>
    <div class="m-n1">
        @if(isset($categories) && $categories->count() > 0) {{-- Tambah cek count() --}}
            @foreach ($categories as $category)
                {{-- PARAMETER ROUTE: untuk Route Model Binding, cukup kirim objek Category --}}
                <a href="{{ route('category.news', $category->category_id) }}" class="btn btn-sm btn-secondary m-1">
                    {{ $category->category_name }} ({{ $category->news_count }})
                </a>
            @endforeach
        @else
            <p>No categories available.</p>
        @endif
    </div>
</div>

<div class="mb-3">
    <h5 class="mb-4 text-uppercase font-weight-bold">Flickr Photos</h5>
    <div class="row">
        @if(isset($flickrPhotos) && $flickrPhotos->count() > 0) {{-- Tambah cek count() --}}
            @foreach ($flickrPhotos as $media)
                <div class="col-4 mb-3">
                    {{-- Asumsi file_path sudah termasuk 'uploads/' atau path lengkap dari root storage --}}
                    <a href="{{ Storage::url($media->file_path) }}" target="_blank">
                        <img class="w-100" src="{{ Storage::url($media->file_path) }}" alt="{{ $media->news->title ?? 'Media' }}">
                    </a>
                </div>
            @endforeach
        @else
            <p>No flickr photos available.</p>
        @endif
    </div>
</div>