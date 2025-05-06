@extends('content/layouts/main')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1">Detail Media</h2>
                    </div>
                </div>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong>Informasi</strong> Media
                        </div>
                        <div class="card-body card-block">
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">ID</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $media->media_id }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">File Path</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static"><a href="{{ asset('storage/' . $media->file_path) }}" target="_blank">{{ $media->file_path }}</a></p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">File Type</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $media->file_type }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Berita</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $media->news->title ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Dibuat Pada</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $media->created_at }}</p>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label class=" form-control-label">Diperbarui Pada</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <p class="form-control-static">{{ $media->updated_at }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('media.edit', $media->media_id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('media.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection