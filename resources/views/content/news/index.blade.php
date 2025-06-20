@extends('content.layouts.main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Berita</h2>
                        <a href="{{ route('news.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Berita</a>
                    </div>
                </div>
            </div>
            
            <div class="row m-t-30">
                <div class="col-md-12">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Isi</th>
                                    <th>Tanggal Publikasi</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Image</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($news as $newsItem)
                                <tr>
                                    <td>{{ $newsItem->title }}</td>
                                    <td>{{ Str::limit($newsItem->content, 100) }}</td>
                                    <td>{{ $newsItem->published_at }}</td>
                                    <td>{{ $newsItem->category->category_name }}</td>
                                    <td>{{ $newsItem->user->name }}</td>
                                    <td>
                                        @if ($newsItem->gambar_berita) {{-- UBAH INI: Gunakan 'gambar_berita' alih-alih 'image' --}}
                                        <img src="{{ asset('storage/uploads/' . $newsItem->gambar_berita) }}" alt="{{ $newsItem->title }}" width="100"> {{-- UBAH INI: Sesuaikan jalurnya --}}
                                        @else
                                        Tidak ada gambar
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="{{ route('news.show', $newsItem->news_id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Lihat">
                                                <i class="zmdi zmdi-eye"></i>
                                            </a>
                                            <a href="{{ route('news.edit', $newsItem->news_id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="{{ route('news.destroy', $newsItem->news_id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="item" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Apakah Anda yakin?')">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data berita.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection