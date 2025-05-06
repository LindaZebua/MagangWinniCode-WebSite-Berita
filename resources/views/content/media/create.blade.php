@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Tambah</strong> Media
                        </div>
                        <div class="card-body card-block">
                            <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="file" class=" form-control-label">File Media</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <input type="file" id="file" name="file" class="form-control-file @error('file') is-invalid @enderror">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3">
                                        <label for="news_id" class=" form-control-label">Berita</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="news_id" id="news_id" class="form-control @error('news_id') is-invalid @enderror">
                                            <option value="">Pilih Berita</option>
                                            @foreach ($news as $item)
                                                <option value="{{ $item->news_id }}" {{ old('news_id') == $item->news_id ? 'selected' : '' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('news_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fa fa-dot-circle-o"></i> Submit
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm">
                                        <i class="fa fa-ban"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection