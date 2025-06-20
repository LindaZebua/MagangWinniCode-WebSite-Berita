@extends('content.layouts.main')

@section('content')

<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            {{-- Bagian Overview --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Overview Dashboard</h2> {{-- Lebih spesifik --}}
                        {{-- Tombol "add item" ini mungkin perlu rute yang lebih spesifik,
                             misalnya untuk menambah berita baru atau user baru --}}
                        <button class="au-btn au-btn-icon au-btn--blue">
                            <i class="zmdi zmdi-plus"></i>Add Item
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bagian Statistik Ringkasan --}}
            <div class="row m-t-25">
                {{-- Total Berita --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c1">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-file-text"></i>
                                </div>
                                <div class="text">
                                    <h2>{{ $newsCount }}</h2>
                                    <span>Total Berita</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Kategori --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c2">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-label"></i>
                                </div>
                                <div class="text">
                                    <h2>{{ $categoriesCount }}</h2>
                                    <span>Total Kategori</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Pengguna --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c3">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-accounts"></i>
                                </div>
                                <div class="text">
                                    <h2>{{ $usersCount }}</h2>
                                    <span>Total Pengguna</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Komentar --}}
                <div class="col-sm-6 col-lg-3">
                    <div class="overview-item overview-item--c4">
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-comment-text"></i>
                                </div>
                                <div class="text">
                                    <h2>{{ $commentsCount }}</h2>
                                    <span>Total Komentar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Media (Tambahan dari Anda) --}}
                <div class="col-sm-6 col-lg-3 mt-4"> {{-- mt-4 untuk margin top jika ada di baris baru --}}
                    <div class="overview-item overview-item--c1"> {{-- Bisa disesuaikan warnanya --}}
                        <div class="overview__inner">
                            <div class="overview-box clearfix">
                                <div class="icon">
                                    <i class="zmdi zmdi-image"></i>
                                </div>
                                <div class="text">
                                    <h2>{{ $mediaCount }}</h2>
                                    <span>Total Media</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> {{-- End of .row m-t-25 (statistik ringkasan) --}}


           <div class="row m-t-30">
    <div class="col-lg-12">
        <h2 class="title-1 m-b-25">Daftar Pengguna</h2>
        <div class="table-responsive table--no-card m-b-40">
            <table class="table table-borderless table-striped table-earning">
                <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Nama') }}</th>
                        <th>{{ __('Username') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Nama Lengkap') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <div class="table-data-feature">
                                {{-- Link untuk melihat detail pengguna --}}
                                <a href="{{ route('users.show', $user->username) }}" class="item" data-toggle="tooltip" data-placement="top" title="View">
                                    <i class="zmdi zmdi-eye"></i>
                                </a>
                                {{-- Link untuk mengedit pengguna --}}
                                <a href="{{ route('users.edit', $user->id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                    <i class="zmdi zmdi-edit"></i>
                                </a>
                                {{-- Form untuk menghapus pengguna --}}
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="item" data-toggle="tooltip" data-placement="top" title="Delete" onclick="return confirm('Are you sure you want to delete this user?')">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

            {{-- Bagian Kategori, Media, dan Berita Terbaru --}}
            <div class="row m-t-30"> {{-- Row baru untuk menampung 3 kolom --}}
                {{-- Kolom Kategori --}}
                <div class="col-lg-4"> {{-- Mengubah menjadi col-lg-4 agar bisa sejajar 3 --}}
                    <h2 class="title-1 m-b-25">Kategori</h2>
                    <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                        <div class="au-card-inner">
                            <div class="table-responsive">
                                <table class="table table-top-countries">
                                    <tbody>
                                        @forelse($categories as $category)
                                        <tr>
                                            <td>{{ $category->category_name }}</td>
                                            {{-- Kolom ini sepertinya untuk nilai numerik terkait kategori,
                                                 jika tidak ada data nyata, mungkin bisa dihapus atau diisi dummy --}}
                                            <td class="text-right">
                                                @if (isset($category->some_value_field) && $category->some_value_field != 0)
                                                    {{ number_format($category->some_value_field, 2) }}
                                                @else
                                                    0.00 {{-- Atau biarkan kosong --}}
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2">Tidak ada kategori ditemukan.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> {{-- End of col-lg-4 (Kategori) --}}

                {{-- Kolom Data Media --}}
                <div class="col-lg-4"> {{-- Mengubah menjadi col-lg-4 --}}
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                        <div class="au-card-title" style="background-image:url"> {{-- Pastikan path gambar benar --}}
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-image"></i>Data Media
                            </h3>
                            {{-- Tombol untuk menambah media baru --}}
                            <a href="{{ route('media.create') }}" class="au-btn-plus">
                                <i class="zmdi zmdi-plus"></i>
                            </a>
                        </div>
                        <div class="au-task js-list-load">
                            <div class="au-task__title">
                                <p>Total Media: {{ $mediaCount ?? 0 }}</p>
                            </div>
                            <div class="au-task-list js-scrollbar3">
                                @forelse($media as $item)
                                    <div class="au-task__item au-task__item--primary">
                                        <div class="au-task__item-inner">
                                            <h5 class="task">
                                                <a href="{{ Storage::url($item->file_path) }}" target="_blank">
                                                    {{ basename($item->file_path) }}
                                                </a>
                                            </h5>
                                            <span class="time">
                                                Tipe: {{ $item->file_type }}
                                                @if ($item->news)
                                                    <br> Berita: {{ $item->news->title }}
                                                @endif
                                                <br> Diunggah: {{ $item->created_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="au-task__item">
                                        <div class="au-task__item-inner">
                                            <h5 class="task">Tidak ada data media yang ditemukan.</h5>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            {{-- Karena $media di DashboardController menggunakan Media::all() (tanpa paginate),
                                 maka tidak perlu link pagination di sini. Jika Anda mau pagination,
                                 ubah di DashboardController menjadi ->paginate() --}}
                            {{-- <div class="au-task__footer">
                                {{ $media->links('pagination::bootstrap-4') }}
                            </div> --}}
                        </div>
                    </div>
                </div> {{-- End of col-lg-4 (Data Media) --}}

                {{-- Kolom Berita Terbaru --}}
                <div class="col-lg-4"> {{-- Mengubah menjadi col-lg-4 --}}
                    <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                        <div class="au-card-title" style="background-image:url"> {{-- Pastikan path gambar benar --}}
                            <div class="bg-overlay bg-overlay--blue"></div>
                            <h3>
                                <i class="zmdi zmdi-rss"></i>Berita Terbaru
                            </h3>
                            <a href="{{ route('news.create') }}" class="au-btn-plus">
                                <i class="zmdi zmdi-plus"></i>
                            </a>
                        </div>
                        <div class="au-inbox-wrap js-inbox-wrap">
                            <div class="au-message js-list-load">
                                <div class="au-message__noti">
                                    <p>Anda memiliki
                                        <span>{{ $newsCount }}</span>
                                        artikel berita total
                                    </p>
                                </div>
                                <div class="au-message-list">
                                    @forelse($news as $item)
                                        <div class="au-message__item {{ $item->created_at->diffInDays(now()) < 1 ? 'unread' : '' }}">
                                            <div class="au-message__item-inner">
                                                <div class="au-message__item-text">
                                                    <div class="avatar-wrap">
                                                        <div class="avatar">
                                                            @if ($item->gambar_berita)
                                                                <img src="{{ asset('storage/uploads/' . $item->gambar_berita) }}" alt="{{ $item->title }}">
                                                            @else
                                                                <img src="{{ asset('images/default-news-avatar.jpg') }}" alt="Default News Image">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text">
                                                        <h5 class="name">{{ $item->title }}</h5>
                                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($item->content), 80, '...') }}</p>
                                                    </div>
                                                </div>
                                                <div class="au-message__item-time">
                                                    <span>{{ $item->published_at ? $item->published_at->diffForHumans() : 'Belum dipublikasikan' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="au-message__item">
                                            <div class="au-message__item-inner">
                                                <div class="text">
                                                    <p>Tidak ada berita tersedia.</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                                {{-- Jika Anda menggunakan paginate di DashboardController untuk $news, tampilkan link pagination --}}
                                <div class="au-message__footer">
                                    {{ $news->links('pagination::bootstrap-4') }} {{-- Pastikan ini ada jika menggunakan paginate --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> {{-- End of col-lg-4 (Berita Terbaru) --}}

            </div> {{-- End of .row m-t-30 (Kategori, Media, Berita Terbaru) --}}

        </div> {{-- End of .container-fluid --}}
    </div> {{-- End of .section__content --}}
</div> {{-- End of .main-content --}}

@endsection