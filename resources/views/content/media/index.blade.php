@extends('content/layouts/main') {{-- Asumsi Anda punya layout app.blade.php --}}

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Media</h2>
                        <a href="{{ route('media.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Media</a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>File Path</th>
                                    <th>File Type</th>
                                    <th>Berita</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($media as $item)
                                    <tr>
                                        <td>{{ $item->media_id }}</td>
                                        <td><a href="{{ asset('storage/' . $item->file_path) }}" target="_blank">{{ $item->file_path }}</a></td>
                                        <td>{{ $item->file_type }}</td>
                                        <td>{{ $item->news->title ?? '-' }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <form action="{{ route('media.destroy', $item->media_id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus media ini?')">
                                                <a href="{{ route('media.show', $item->media_id) }}" class="btn btn-sm btn-info">Lihat</a>
                                                <a href="{{ route('media.edit', $item->media_id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data media.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $media->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection