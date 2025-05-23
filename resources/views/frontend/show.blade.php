<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }}</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    </head>
<body>
    <header>
        <h1>Situs Berita Sederhana</h1>
        <nav>
            <a href="{{ route('beranda') }}">Beranda</a>
            @if(isset($categories))
                @foreach($categories as $category)
                    <a href="{{ route('categories', $category->slug) }}">{{ $category->name }}</a>
                @endforeach
            @endif
        </nav>
    </header>

    <main>
        <section class="news-detail">
            <h2>{{ $news->title }}</h2>
            <small>Kategori: {{ $news->category->name }} - Dipublikasikan pada {{ $news->created_at->format('d M Y') }}</small>
            <p>{{ $news->content }}</p>
        </section>

        <section class="related-news">
            <h3>Berita Terkait</h3>
            @if(isset($beritaTerkait) && $beritaTerkait->count() > 0)
                <ul>
                    @foreach($beritaTerkait as $terkait)
                        <li><a href="{{ route('news.show', $terkait->slug) }}">{{ $terkait->title }}</a></li>
                    @endforeach
                </ul>
            @else
                <p>Tidak ada berita terkait.</p>
            @endif
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Situs Berita Sederhana</p>
    </footer>
</body>
</html>