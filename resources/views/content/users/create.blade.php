@extends('content/layouts/main')

@section('content')
<div class="container">
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong>Tambahkan User</strong>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('users.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">{{ __('Nama Lengkap') }}</label>
                                        <input id="nama_lengkap" type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required autocomplete="nama_lengkap">
                                        @error('nama_lengkap')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">{{ __('Username') }}</label>
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('Alamat Email') }}</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('Password') }}</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password-confirm" class="form-label">{{ __('Konfirmasi Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>


                                    <div class="mb-3">
                                        <label for="role" class="form-label">{{ __('Role') }}</label>
                                        <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                            <option value="">{{ __('Pilih Role') }}</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('Admin') }}</option>
                                            <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>{{ __('Editor') }}</option>
                                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>{{ __('User') }}</option>
                                        </select>
                                        @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                                        <a href="{{ route('users.index') }}" class="btn btn-secondary">{{ __('Batal') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection