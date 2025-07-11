<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BREAKING NEWS</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="{{ asset('assets/img/favicon.ico') }}" rel="icon">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-fluid d-none d-lg-block">
        <div class="row align-items-center bg-dark px-lg-5">
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-sm bg-dark p-0">
                    <ul class="navbar-nav ml-n2">
                        <li class="nav-item border-right border-secondary">
                            <a class="nav-link text-body small"
                                href="#">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</a>
                        </li>
                        <li class="nav-item border-right border-secondary">
                            <a class="nav-link text-body small" href="#">Advertise</a>
                        </li>
                        <li class="nav-item border-right border-secondary">
                            <a class="nav-link text-body small" href="#">Contact</a> {{-- Perbaiki route contact --}}
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body small" href="{{ route('login') }}">Login</a>
                            {{-- Perbaiki route login --}}
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 text-right d-none d-md-block">
                <nav class="navbar navbar-expand-sm bg-dark p-0">
                    <ul class="navbar-nav ml-auto mr-n2">
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-twitter"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-facebook-f"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-linkedin-in"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-instagram"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-google-plus-g"></small></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-body" href="#"><small class="fab fa-youtube"></small></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row align-items-center bg-white py-3 px-lg-5">
            <div class="col-lg-4">
                <a href="index.html" class="navbar-brand p-0 d-none d-lg-block">
                    <h1 class="m-0 display-4 text-uppercase text-primary">Breaking<span
                            class="text-secondary font-weight-normal">News</span></h1>
                </a>
            </div>
            <div class="col-lg-8 text-center text-lg-right">
                <a href="https://htmlcodex.com"><img class="img-fluid" src="img/ads-728x90.png" alt=""></a>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
            <a href="{{ route('home') }}" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-uppercase text-primary">Biz<span
                        class="text-white font-weight-normal">News</span></h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    {{-- Tautan Home --}}
                    <a href="{{ route('home') }}"
                        class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>

                    {{-- LOOP UNTUK KATEGORI --}}
                    {{-- Pastikan variabel $categories dikirim dari controller yang merender view ini. --}}
                    @isset($categories)
                    @foreach ($categories as $category)
                    {{-- Logika untuk menentukan kategori 'active' --}}
                    @php
                    $isActiveCategory = false;
                    // Cek jika rute saat ini adalah categories.show DAN category_id cocok
                    if (request()->routeIs('categories.show') && request()->route('category') &&
                    request()->route('category')->category_id == $category->category_id) {
                    $isActiveCategory = true;
                    }
                    @endphp
                    {{-- Tautan kategori dengan parameter ID --}}
                    <a href="{{ route('categories.show', $category->category_id) }}"
                        class="nav-item nav-link {{ $isActiveCategory ? 'active' : '' }}">
                        {{ $category->category_name }}
                    </a>
                    @endforeach
                    @endisset
                    {{-- AKHIR LOOP KATEGORI --}}

                    {{-- Tautan Contact --}}
                    <a href="#" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
                </div>
                <div class="input-group ml-auto d-none d-lg-flex" style="width: 100%; max-width: 300px;">
                    <input type="text" class="form-control border-0" placeholder="Keyword">
                    <div class="input-group-append">
                        <button class="input-group-text bg-primary text-dark border-0 px-3"><i
                                class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- Navbar End -->


    <!-- Main News Slider Start -->
    <div class="container-fluid">
        <div class="row">
            {{-- Bagian Carousel Utama (mengambil 7 kolom di layar besar) --}}
            <div class="col-lg-7 px-0">
                <div class="owl-carousel main-carousel position-relative">
                    {{-- Loop melalui berita terbaru untuk carousel utama --}}
                    {{-- PERUBAHAN: Dari $latestNews menjadi $mainCarouselNews --}}
                    @foreach($mainCarouselNews as $newsItem)
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        {{-- Tampilkan gambar berita --}}
                        <img class="img-fluid h-100" src="{{ Storage::url('uploads/' . $newsItem->gambar_berita) }}"
                            style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">
                                {{-- Tampilkan kategori berita --}}
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href="{{ route('categories.show', $newsItem->category->category_id) }}">
                                    {{ $newsItem->category->category_name ?? 'Uncategorized' }}
                                </a>
                                {{-- Tampilkan tanggal publikasi berita --}}
                                <a class="text-white" href="#">
                                    {{ \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') }}
                                </a>
                            </div>
                            {{-- Tampilkan judul berita --}}
                            <a class="h2 m-0 text-white text-uppercase font-weight-bold"
                                href="{{ route('news.show', $newsItem->news_id) }}">
                                {{ $newsItem->title }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Bagian Berita Kecil (mengambil 5 kolom di layar besar) --}}
            <div class="col-lg-5 px-0">
                <div class="row mx-0">
                    {{-- Loop melalui berita untuk bagian kecil --}}
                    @foreach($sideNews as $sideNewsItem)
                    <div class="col-md-6 px-0">
                        <div class="position-relative overflow-hidden" style="height: 250px;">
                            {{-- Tampilkan gambar berita untuk bagian kecil --}}
                            <img class="img-fluid h-100"
                                src="{{ Storage::url('uploads/' . $sideNewsItem->gambar_berita) }}"
                                style="object-fit: cover;">
                            <div class="overlay">
                                <div class="mb-2">
                                    {{-- Tampilkan kategori berita untuk bagian kecil --}}
                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                        href="{{ route('categories.show', $sideNewsItem->category->category_id) }}">
                                        {{ $sideNewsItem->category->category_name ?? 'Uncategorized' }}
                                    </a>
                                    {{-- Tampilkan tanggal publikasi berita untuk bagian kecil --}}
                                    <a class="text-white" href="#">
                                        {{ \Carbon\Carbon::parse($sideNewsItem->published_at)->format('M d, Y') }}
                                    </a>
                                </div>
                                {{-- Tampilkan judul berita untuk bagian kecil --}}
                                <a class="h6 m-0 text-white text-uppercase font-weight-bold"
                                    href="{{ route('news.show', $sideNewsItem->news_id) }}">
                                    {{ $sideNewsItem->title }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    </div>
    <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="#">Latest in entertainment...</a>
    </div>

    <!-- Main News Slider End -->


    <!-- Breaking News Start -->
    <div class="container-fluid bg-dark py-3 mb-3">
        <div class="container">
            <div class="row align-items-center bg-dark">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div class="bg-primary text-dark text-center font-weight-medium py-2" style="width: 170px;">
                            Breaking News</div>
                        <div class="owl-carousel tranding-carousel position-relative d-inline-flex align-items-center ml-3"
                            style="width: calc(100% - 170px); padding-right: 90px;">
                            <div class="text-truncate"><a class="text-white text-uppercase font-weight-semi-bold"
                                    href="">Aplikasi berita buatan mahasiswa lokal mendadak viral karena mampu
                                    menyarankan berita sesuai emosi pengguna. Katanya sih, AI-nya peka banget!</a></div>
                            <div class="text-truncate"><a class="text-white text-uppercase font-weight-semi-bold"
                                    href="">Lorem ipsum dolor sit amet elit. Proin interdum lacus eget ante tincidunt,
                                    sed faucibus nisl sodales</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breaking News End -->


    <!-- Featured News Slider Start -->

   <div class="container-fluid pt-5 mb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold">Media News</h4>
        </div>
        <div class="owl-carousel news-carousel carousel-item-4 position-relative">
            {{-- Gunakan variabel yang berisi banyak berita, yaitu $featuredNewsCarousel --}}
            @foreach($featuredNewsCarousel as $newsItem)
            <div class="position-relative overflow-hidden" style="height: 300px;">
                <img class="img-fluid h-100"
                    {{-- Perbaiki di sini: Gunakan gambar_berita dari model News --}}
                    src="{{ asset('storage/uploads/' . ($newsItem->gambar_berita ?? 'default-news-image.jpg')) }}"
                    style="object-fit: cover;" alt="{{ $newsItem->title }}">
                <div class="overlay">
                    <div class="mb-2">
                        {{-- Pastikan category ada sebelum mencoba mengaksesnya --}}
                        @if($newsItem->category)
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                            href="{{ route('categories.show', $newsItem->category->category_id) }}">
                            {{ $newsItem->category->category_name }}
                        </a>
                        @else
                        {{-- Fallback jika berita tidak punya kategori --}}
                        <span
                            class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2">Uncategorized</span>
                        @endif

                        {{-- Pastikan published_at ada --}}
                        <a class="text-white" href="{{ route('news.single', $newsItem->news_id) }}">
                            <small>{{ \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') }}</small>
                        </a>
                    </div>
                    <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold"
                        href="{{ route('news.single', $newsItem->news_id) }}">
                        {{ Str::limit($newsItem->title, 50) }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
    <!-- Featured News Slider End -->


    <!-- News With Sidebar Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                {{-- KOLOM UTAMA UNTUK LATEST NEWS - Diubah dari col-lg-8 menjadi col-lg-7 --}}
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-12">
                            <div class="section-title">
                                <h4 class="m-0 text-uppercase font-weight-bold">Latest News</h4>
                                <a class="text-secondary font-weight-medium text-decoration-none" href="/all-news">View All</a>
                            </div>
                        </div>

                        {{-- Loop untuk Berita Terbaru --}}
                        {{-- OLD: @foreach ($latestNews->take(6) as $newsItem) --}}
                        @foreach ($news as $newsItem) {{-- CHANGE THIS LINE --}}
                        <div class="col-lg-6 mb-3">
                            <article class="position-relative">
                                <div class="img-container" style="height: 200px; overflow: hidden;">
                                    <img class="img-fluid w-100 h-100"
                                        src="{{ $newsItem->gambar_berita ? Storage::url('uploads/' . $newsItem->gambar_berita) : asset('img/default-news.jpg') }}"
                                        style="object-fit: cover;"
                                        alt="{{ $newsItem->title }}">
                                </div>
                                <div class="bg-white border border-top-0 p-4">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                            href="{{ route('category.show', $newsItem->category) }}">
                                            {{ $newsItem->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a class="text-body" href="{{ route('news.single', $newsItem) }}">
                                            <small><time datetime="{{ $newsItem->published_at->format('Y-m-d') }}">{{ $newsItem->published_at->format('M d, Y') }}</time></small>
                                        </a>
                                    </div>
                                    <a class="h5 d-block mb-3 text-secondary text-uppercase font-weight-bold text-truncate-2"
                                        href="{{ route('news.single', $newsItem) }}">
                                        {{ $newsItem->title }}
                                    </a>
                                    <p class="m-0 text-truncate-3">{{ Str::limit(strip_tags($newsItem->content), 120) }}</p>
                                </div>
                                <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle mr-2"
                                            src="{{ $newsItem->user->profile_photo_path ? Storage::url('uploads/' . $newsItem->user->profile_photo_path) : asset('img/user.jpg') }}"
                                            width="25" height="25" alt="{{ $newsItem->user->name }}">
                                        <small>{{ $newsItem->user->name ?? 'Unknown' }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <small class="ml-3"><i class="far fa-eye mr-2"></i>{{ $newsItem->views ?? 0 }}</small>
                                        <a href="{{ route('news.single', $newsItem) }}#comments-section" class="ml-3 text-decoration-none text-muted">
                                            <i class="far fa-comment mr-2"></i>{{ $newsItem->comments_count ?? 0 }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>
                    {{-- Tambahkan Pagination jika diperlukan --}}
                    @if($latestNewsPaginated instanceof \Illuminate\Pagination\LengthAwarePaginator) {{-- KEEP THIS --}}
                    <div class="col-12 mt-4">
                        {{ $latestNewsPaginated->links() }} {{-- KEEP THIS --}}
                    </div>
                    @endif
                </div>



                {{-- KOLOM UNTUK SIDEBAR - Diubah dari col-lg-4 menjadi col-lg-5 --}}
                <div class="col-lg-5">
                    {{-- Bagian Popular News (Trending News) --}}
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Trending News</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            @foreach($popularNews as $pNews)
                            <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                <img class="img-fluid"
                                    src="{{ $pNews->gambar_berita ? Storage::url('uploads/' . $pNews->gambar_berita) : asset('img/default-small.jpg') }}"
                                    alt="{{ $pNews->title }}"
                                    style="width: 100px; height: 100%; object-fit: cover;">
                                <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                    <div class="mb-2">
                                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2"
                                            href="{{ route('category.show', $pNews->category) }}">
                                            {{ $pNews->category->category_name ?? 'Uncategorized' }}
                                        </a>
                                        <a class="text-body" href="{{ route('news.single', $pNews) }}">
                                            <small><time datetime="{{ $pNews->published_at->format('Y-m-d') }}">{{ $pNews->published_at->format('M d, Y') }}</time></small>
                                        </a>
                                    </div>
                                    <a class="h6 m-0 text-truncate pr-2" href="{{ route('news.single', $pNews) }}">{{ $pNews->title }}</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Bagian Follow Us --}}
                    <aside class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            <a href="https://facebook.com/yourpage"
                                class="d-block w-100 text-white text-decoration-none mb-3" style="background: #39569E;">
                                <i class="fab fa-facebook-f text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Fans</span>
                            </a>
                            <a href="https://twitter.com/youraccount"
                                class="d-block w-100 text-white text-decoration-none mb-3" style="background: #52AAF4;">
                                <i class="fab fa-twitter text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                            <a href="https://linkedin.com/in/yourprofile"
                                class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">
                                <i class="fab fa-linkedin-in text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Connects</span>
                            </a>
                            <a href="https://instagram.com/youraccount"
                                class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">
                                <i class="fab fa-instagram text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                            <a href="https://youtube.com/yourchannel"
                                class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">
                                <i class="fab fa-youtube text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Subscribers</span>
                            </a>
                            <a href="https://vimeo.com/yourchannel"
                                class="d-block w-100 text-white text-decoration-none" style="background: #055570;">
                                <i class="fab fa-vimeo-v text-center py-4 mr-3"
                                    style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                                <span class="font-weight-medium">12,345 Followers</span>
                            </a>
                        </div>
                    </aside>

                    {{-- Bagian Categories --}}
                    <div class="mb-3">
                        <div class="section-title mb-0">
                            <h4 class="m-0 text-uppercase font-weight-bold">Categories</h4>
                        </div>
                        <div class="bg-white border border-top-0 p-3">
                            @foreach($categories as $category)
                            <a href="{{ route('category.show', $category) }}" class="d-block d-flex justify-content-between align-items-center text-body text-decoration-none mb-3">
                                <h6 class="text-uppercase font-weight-medium"><i class="fa fa-angle-right mr-2"></i>{{ $category->category_name }}</h6>
                                <span class="badge badge-primary font-weight-normal">{{ $category->news_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Get In Touch</h5>
                <p class="font-weight-medium"><i class="fa fa-map-marker-alt mr-2"></i>123 Street, New York, USA</p>
                <p class="font-weight-medium"><i class="fa fa-phone-alt mr-2"></i>+012 345 67890</p>
                <p class="font-weight-medium"><i class="fa fa-envelope mr-2"></i>info@example.com</p>
                <h6 class="mt-4 mb-3 text-white text-uppercase font-weight-bold">Follow Us</h6>
                <div class="d-flex justify-content-start">
                    <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-lg btn-secondary btn-lg-square" href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Popular News</h5>
                <div class="mb-3">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">Business</a>
                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                    </div>
                    <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum dolor sit amet
                        elit. Proin vitae porta diam...</a>
                </div>
                <div class="mb-3">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">Business</a>
                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                    </div>
                    <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum dolor sit amet
                        elit. Proin vitae porta diam...</a>
                </div>
                <div class="">
                    <div class="mb-2">
                        <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="">Business</a>
                        <a class="text-body" href=""><small>Jan 01, 2045</small></a>
                    </div>
                    <a class="small text-body text-uppercase font-weight-medium" href="">Lorem ipsum dolor sit amet
                        elit. Proin vitae porta diam...</a>
                </div>
            </div>

            {{-- Ini adalah Categories di FOOTER, bukan di sidebar utama --}}
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Categories</h5>
                <div class="m-n1">
                    {{-- PERHATIKAN: rute di footer ini masih pakai categories.show dengan ID. Sesuaikan jika perlu. --}}
                    @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category->category_id) }}"
                        class="btn btn-sm btn-secondary m-1">{{ $category->category_name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold">Flickr Photos</h5>
                <div class="row">
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-1.jpg" alt=""></a>
                    </div>
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-2.jpg" alt=""></a>
                    </div>
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-3.jpg" alt=""></a>
                    </div>
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-4.jpg" alt=""></a>
                    </div>
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-5.jpg" alt=""></a>
                    </div>
                    <div class="col-4 mb-3">
                        <a href=""><img class="w-100" src="img/news-110x110-1.jpg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer End -->

    @yield('content')
    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top"><i class="fa fa-arrow-up"></i></a>




    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>

    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>