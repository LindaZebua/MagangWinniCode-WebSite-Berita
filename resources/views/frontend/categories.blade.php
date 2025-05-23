<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori: {{ $kategori->name }}</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    </head>
<body>
    <header>
        <h1>Situs Berita Sederhana</h1>
        <nav>
            <a href="{{ route('beranda') }}">Beranda</a>
            @if(isset($categories))
                @foreach($categories as $category)
                    <a href="{{ route('categories', $category->slug) }}" class="{{ $category->slug === $kategori->slug ? 'active' : '' }}">{{ $category->name }}</a>
                @endforeach
            @endif
        </nav>
    </header>

    <main>
        <h2>Kategori: {{ $kategori->name }}</h2>
        @if(isset($beritaKategori) && $beritaKategori->count() > 0)
            <ul>
                @foreach($beritaKategori as $berita)
                    <li>
                        <a href="{{ route('news.show', $berita->slug) }}">{{ $berita->title }}</a>
                        <small>({{ $berita->created_at->format('d M Y') }})</small>
                    </li>
                @endforeach
            </ul>
            {{ $beritaKategori->links() }} @else
            <p>Belum ada berita di kategori ini.</p>
        @endif
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Situs Berita Sederhana</p>
    </footer>
</body>
</html>