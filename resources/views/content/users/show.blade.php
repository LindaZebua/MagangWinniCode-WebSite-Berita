@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Detail Pengguna</strong>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control-plaintext" value="{{ $user->name }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('Username') }}</label>
                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control-plaintext" value="{{ $user->username }}" readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Alamat Email') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control-plaintext" value="{{ $user->email }}" readonly>
                                </div>
                            </div>

                            @if(isset($user->nama_lengkap))
                            <div class="mb-3 row">
                                <label for="nama_lengkap" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>
                                <div class="col-md-6">
                                    <input id="nama_lengkap" type="text" class="form-control-plaintext" value="{{ $user->nama_lengkap }}" readonly>
                                </div>
                            </div>
                            @endif

                            @if(isset($user->role))
                            <div class="mb-3 row">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>
                                <div class="col-md-6">
                                    <input id="role" type="text" class="form-control-plaintext" value="{{ ucfirst($user->role) }}" readonly>
                                </div>
                            </div>
                            @endif

                            {{-- You can add more user details here based on your database schema --}}
                            @if(isset($user->created_at))
                            <div class="mb-3 row">
                                <label for="created_at" class="col-md-4 col-form-label text-md-end">{{ __('Dibuat Pada') }}</label>
                                <div class="col-md-6">
                                    <input id="created_at" type="text" class="form-control-plaintext" value="{{ $user->created_at->format('d M Y, H:i') }}" readonly>
                                </div>
                            </div>
                            @endif

                            @if(isset($user->updated_at))
                            <div class="mb-3 row">
                                <label for="updated_at" class="col-md-4 col-form-label text-md-end">{{ __('Terakhir Diperbarui') }}</label>
                                <div class="col-md-6">
                                    <input id="updated_at" type="text" class="form-control-plaintext" value="{{ $user->updated_at->format('d M Y, H:i') }}" readonly>
                                </div>
                            </div>
                            @endif

                            <div class="d-grid gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">{{ __('Edit') }}</a>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection