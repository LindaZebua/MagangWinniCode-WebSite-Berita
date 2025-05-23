<!DOCTYPE HTML>
<html>

<head>
    <title>BERITA TERKINI</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dropotron.min.js') }}"></script>
    <script src="{{ asset('js/skel.min.js') }}"></script>
    <script src="{{ asset('js/skel-layers.min.js') }}"></script>
    <script src="{{ asset('js/init.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/skel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/skel.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </noscript>
</head>

<body class="homepage">

    <div id="header">
        <div class="container">

            <h1><a href="{{ route('beranda') }}" id="logo">BERITA TERKINI</a></h1>

            <nav id="nav">
                <ul>
                    <li><a href="{{ route('beranda') }}">Home</a></li>
                    <li>
                        <a href="#">Kategori</a>
                        <ul>
                            @foreach ($categories as $category)
                            <li><a href="{{ route('home.category', ['slug' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="#">Olaraga</a></li>
                    <li><a href="#">Teknologi</a></li>
                    <li><a href="#">Hiburan</a></li>
                </ul>
            </nav>
            <div id="banner">
                <div class="container">
                    <section>
                        <header class="major">
                            <h2>Selamat Datang di Berita Terkini!</h2>
                            <span class="byline">Dapatkan informasi terbaru dan terpercaya dari berbagai kategori.</span>
                        </header>
                        @guest
                        <a href="{{ route('login') }}" class="button alt">Login</a>
                        @else
                        <p>Selamat datang, {{ Auth::user()->name }}!</p>
                        <a href="{{ route('dashboard') }}" class="button alt">Dashboard</a>
                        @endguest
                    </section>
                </div>
            </div>

        </div>
    </div>

    <div class="wrapper style2">
        <section class="container">
            <header class="major">
                <h2>Berita Unggulan</h2>
                <span class="byline">Berita pilihan hari ini</span>
            </header>
            <div class="row no-collapse-1">
                @foreach ($featuredNews as $news)
                <section class="4u">
                    <a href="{{ route('home.show', ['slug' => $news->slug]) }}" class="image feature">
                        @if ($news->gambar_berita)
                        <img src="{{ asset('storage/' . $news->gambar_berita) }}" alt="{{ $news->title }}" width="368" height="180">
                        @else
                        <img src="{{ asset('assets/images/default.jpg') }}" alt="Default Image" width="368" height="180">
                        @endif
                    </a>
                    <h3><a href="{{ route('home.show', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h3>
                    <p>{{ Str::limit($news->content, 100) }}</p>
                </section>
                @endforeach
            </div>
        </section>
    </div>

    <div id="main" class="wrapper style1">
        <section class="container">
            <header class="major">
                <h2>Berita Terbaru</h2>
                <span class="byline">Kumpulan berita terbaru dari berbagai sumber</span>
            </header>
            <div class="row">

                <div class="8u">
                    <section>
                        @foreach ($latestNews as $news)
                        <article class="box post">
                            <header>
                                <h3><a href="{{ route('home.show', ['slug' => $news->slug]) }}">{{ $news->title }}</a></h3>
                                <p class="post-meta">
                                    Kategori: <a href="{{ route('home.category', ['slug' => $news->category->slug]) }}">{{ $news->category->name }}</a> |
                                    Diposting oleh: {{ $news->user->name }} |
                                    Tanggal: {{ $news->published_at->format('d M Y') }}
                                </p>
                            </header>
                            <a href="{{ route('home.show', ['slug' => $news->slug]) }}" class="image featured">
                                @if ($news->gambar_berita)
                                <img src="{{ asset('storage/' . $news->gambar_berita) }}" alt="{{ $news->title }}">
                                @else
                                <img src="{{ asset('assets/images/default-full.jpg') }}" alt="Default Image">
                                @endif
                            </a>
                            <p>{{ Str::limit($news->content, 250) }}</p>
                            <footer>
                                <ul class="actions">
                                    <li><a href="{{ route('home.show', ['slug' => $news->slug]) }}" class="button">Baca Selengkapnya</a></li>
                                    <li><a href="{{ route('home.show', ['slug' => $news->slug]) }}#comments">{{ $news->comments->count() }} Komentar</a></li>
                                </ul>
                            </footer>
                        </article>
                        @endforeach

                        {{ $latestNews->links() }}
                    </section>
                </div>

                <div class="4u">
                    <section>
                        <header class="major">
                            <h2>Berita Populer</h2>
                            <span class="byline">Berita yang paling banyak dilihat</span>
                        </header>
                        <ul class="default">
                            @foreach ($popularNews as $news)
                            <li><a href="{{ route('home.show', ['slug' => $news->slug]) }}">{{ $news->title }}</a></li>
                            @endforeach
                        </ul>
                    </section>
                    <section>
                        <header class="major">
                            <h2>Kategori Populer</h2>
                            <span class="byline">Kategori berita yang paling banyak dicari</span>
                        </header>
                        <ul class="default">
                            @foreach ($popularCategories as $category)
                            <li><a href="{{ route('home.category', ['slug' => $category->slug]) }}">{{ $category->name }} ({{ $category->news_count }})</a></li>
                            @endforeach
                        </ul>
                    </section>
                </div>

            </div>
        </section>
    </div>

    <div id="footer">
        <div class="container">

            <div class="row">
                <div class="8u">
                    <section>
                        <header class="major">
                            <h2>Tentang Kami</h2>
                            <span class="byline">Informasi mengenai portal berita ini</span>
                        </header>
                        <p>Berita Terkini adalah portal berita yang menyajikan informasi terbaru dan terpercaya dari berbagai bidang. Kami berkomitmen untuk memberikan berita yang akurat, cepat, dan relevan bagi pembaca kami.</p>
                        <ul class="default">
                            <li><a href="#">Kebijakan Privasi</a></li>
                            <li><a href="#">Syarat dan Ketentuan</a></li>
                            <li><a href="#">Kontak Kami</a></li>
                        </ul>
                    </section>
                </div>
                <div class="4u">
                    <section>
                        <header class="major">
                            <h2>Hubungi Kami</h2>
                            <span class="byline">Jangan ragu untuk menghubungi kami</span>
                        </header>
                        <ul class="contact">
                            <li>
                                <span class="address">Alamat</span>
                                <span>Jl. Contoh No. 123<br>Jakarta, Indonesia</span>
                            </li>
                            <li>
                                <span class="mail">Email</span>
                                <span><a href="#">info@beritaterkini.com</a></span>
                            </li>
                            <li>
                                <span class="phone">Telepon</span>
                                <span>(021) 12345678</span>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>

            <div class="copyright">
                &copy; {{ date('Y') }} Berita Terkini. All rights reserved. | Design: <a href="http://templated.co">TEMPLATED</a>
            </div>

        </div>
    </div>

</body>

</html>