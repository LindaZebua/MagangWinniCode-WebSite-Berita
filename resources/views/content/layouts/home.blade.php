@extends('content.layouts.main')

@section('content')
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary">
            <i class="fa fa-users fa-3x"></i>
            <div class="info">
                <h4 class="text-white">Users</h4>
                <p class="text-white">
                    @if(isset($usersCount))
                        {{ $usersCount }}
                    @else
                        0
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info">
            <i class="fa fa-newspaper-o fa-3x"></i>
            <div class="info">
                <h4 class="text-white">Total Berita</h4>
                <p class="text-white">
                    @if(isset($totalBerita))
                        {{ $totalBerita }}
                    @else
                        0
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning">
            <i class="fa fa-calendar fa-3x"></i>
            <div class="info">
                <h4 class="text-white">Berita Hari Ini</h4>
                <p class="text-white">
                    @if(isset($beritaHariIni))
                        {{ $beritaHariIni }}
                    @else
                        0
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger">
            <i class="fa fa-files-o fa-3x"></i>
            <div class="info">
                <h4 class="text-white">Berita Minggu Ini</h4>
                <p class="text-white">
                    @if(isset($beritaMingguIni))
                        {{ $beritaMingguIni }}
                    @else
                        0
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Kategori Berita Terbanyak</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Kategori</th>
                            <th>Total Berita</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $kategoriTerbanyak->category_name ?? 'Tidak Ada Data' }}</td>
                            <td>{{ $kategoriTerbanyak->total ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection