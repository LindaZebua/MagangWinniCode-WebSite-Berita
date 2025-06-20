@extends('content.layouts.main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Daftar Kategori</h2>
                        <a href="{{ route('categories.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Kategori</a>
                    </div>

                    <!-- Tambahkan ini -->
                   

            <div class="row m-t-30">
                <div class="col-md-12">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="table-responsive table--no-card m-b-30">
                        <table class="table table-borderless table-striped table-earning">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                <tr>
                                    <td>{{ $category->category_name }}</td>
                                    <td>
                                        <div class="table-data-feature">
                                            <a href="{{ route('categories.show', $category->category_id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Lihat">
                                                <i class="zmdi zmdi-eye"></i>
                                            </a>
                                            <a href="{{ route('categories.edit', $category->category_id) }}" class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="zmdi zmdi-edit"></i>
                                            </a>
                                            <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" style="display: inline-block;">
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
                                    <td colspan="2" class="text-center">Tidak ada data kategori.</td>
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