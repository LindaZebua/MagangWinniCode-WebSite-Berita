@extends('content.layouts.main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Daftar Komentar</h2>
                        <a href="{{ route('comments.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Komentar
                        </a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="table-responsive table--no-card m-b-25">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Teks Komentar</th>
                                    <th>Berita</th>
                                    <th>Pengguna</th>
                                    <th>Tanggal Komentar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comments as $comment)
                                <tr>
                                    <td>{{ $comment->comment_id }}</td>
                                    <td>{{ Str::limit($comment->comment_text, 100) }}</td> {{-- Membatasi teks agar tidak terlalu panjang --}}
                                    <td>{{ $comment->news->title ?? 'Berita Tidak Ditemukan' }}</td> {{-- Handle jika berita dihapus --}}
                                    <td>{{ $comment->user->name ?? 'Pengguna Tidak Dikenal' }}</td> {{-- Handle jika pengguna dihapus --}}
                                    <td>{{ \Carbon\Carbon::parse($comment->commented_at)->format('d M Y, H:i') }}</td> {{-- Format tanggal lebih baik --}}
                                    <td>
                                        <a href="{{ route('comments.edit', $comment->comment_id) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada komentar yang tersedia.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $comments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection