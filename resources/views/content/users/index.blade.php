@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Data Pengguna</h2>
                        <a href="{{ route('users.create') }}" class="au-btn au-btn-icon au-btn--green">
                            <i class="zmdi zmdi-plus"></i>Tambah Pengguna</a>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">

                    @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
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
                                <td>{{ ucfirst($user->role) }}</td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">{{ __('Lihat') }}</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                            {{ __('Hapus') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">{{ __('Tidak ada pengguna.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection