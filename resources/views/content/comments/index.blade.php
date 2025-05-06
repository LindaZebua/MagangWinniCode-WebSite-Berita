@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Daftar Komentar</h2>
                        <a href="{{ route('comments.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Komentar</a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <div class="table-responsive table--no-card m-b-30">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
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
                                @foreach($comments as $comment)
                                <tr>
                                    <td>{{ $comment->comment_id }}</td>
                                    <td>{{ $comment->comment_text }}</td>
                                    <td>{{ $comment->news->title }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{ $comment->commented_at }}</td>
                                    <td>
                                        <a href="{{ route('comments.edit', $comment->comment_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('comments.destroy', $comment->comment_id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection