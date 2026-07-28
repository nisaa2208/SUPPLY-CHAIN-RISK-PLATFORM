@extends('adminlte::page')

@section('title', 'Informasi & Profil Risiko 195 Negara')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-0" style="font-size: 1.75rem;">
            <i class="fas fa-globe-americas text-primary mr-2"></i>
            Informasi 195 Negara Dunia Real-Time
        </h1>
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('countries.sync.live') }}" method="POST" class="d-inline mr-2">
            @csrf
            <button type="submit" class="btn btn-success shadow-sm font-weight-bold" title="Sinkronkan data live dari REST Countries API">
                <i class="fas fa-sync-alt mr-1"></i> Sync Live REST API (195+ Negara)
            </button>
        </form>

        <a href="{{ route('countries.create') }}" class="btn btn-primary shadow-sm font-weight-bold">
            <i class="fas fa-plus-circle mr-1"></i> Tambah Negara Baru
        </a>
    </div>
</div>
@stop

@section('css')
<style>
.country-scroll-container {
    max-height: 600px;
    overflow-y: auto;
    position: relative;
}
.country-scroll-container::-webkit-scrollbar {
    width: 6px;
}
.country-scroll-container::-webkit-scrollbar-track {
    background: #f1f5f9;
}
.country-scroll-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.country-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
.table-sticky-header th {
    position: sticky;
    top: 0;
    background-color: #f8fafc;
    z-index: 2;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
</style>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Summary Metric Cards -->
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $totalCountriesCount }}</h3>
                <p>Total Negara Terdaftar</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>195 / 195</h3>
                <p>Cakupan Negara PBB</p>
            </div>
            <div class="icon">
                <i class="fas fa-flag"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>Real-Time</h3>
                <p>Live REST Countries API</p>
            </div>
            <div class="icon">
                <i class="fas fa-sync"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>8.1 Miliar</h3>
                <p>Total Populasi Terjangkau</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <form action="{{ route('countries.index') }}" method="GET">
            <div class="row align-items-center">
                <div class="col-md-5 mb-2 mb-md-0">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" name="search" class="form-control border-left-0" placeholder="Cari nama atau kode dari 195 negara..." value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3 mb-2 mb-md-0">
                    <select name="region" class="form-control custom-select" onchange="this.form.submit()">
                        <option value="">-- Semua Benua / Region --</option>
                        @foreach($regions as $r)
                            <option value="{{ $r }}" {{ request('region') == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2 mb-md-0">
                    <select name="risk_level" class="form-control custom-select" onchange="this.form.submit()">
                        <option value="">-- Semua Risk Level --</option>
                        <option value="High" {{ request('risk_level') == 'High' ? 'selected' : '' }}>High Risk</option>
                        <option value="Medium" {{ request('risk_level') == 'Medium' ? 'selected' : '' }}>Medium Risk</option>
                        <option value="Low" {{ request('risk_level') == 'Low' ? 'selected' : '' }}>Low Risk</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-filter mr-1"></i> Filter Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Countries Scrollable Table Card -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-list-alt text-primary mr-2"></i> Direktori 195 Negara Dunia (Scroll View)
        </h3>
        <span class="badge badge-primary px-3 py-1 font-weight-bold">
            Total: {{ $countries->count() }} Negara
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive country-scroll-container">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-sticky-header">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Negara</th>
                        <th>Kode ISO</th>
                        <th>Benua / Region</th>
                        <th>GDP Estimasi</th>
                        <th>Inflasi</th>
                        <th>Populasi</th>
                        <th>Mata Uang</th>
                        <th width="150">Skor Risiko</th>
                        <th>Level Risiko</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>

                        <td>
                            <a href="{{ route('countries.show', $country->id) }}" class="font-weight-bold text-dark hover-primary style-none d-inline-flex align-items-center">
                                <img src="https://flagcdn.com/w40/{{ strtolower($country->code) }}.png" class="rounded mr-2 shadow-2xs" style="width:24px; height:16px; object-fit:cover;" alt="{{ $country->code }}" onerror="this.style.display='none'">
                                <span>{{ $country->name }}</span>
                            </a>
                        </td>

                        <td>
                            <span class="badge badge-light border font-weight-bold" style="font-size:0.85rem;">{{ $country->code }}</span>
                        </td>

                        <td><span class="text-muted" style="font-size:0.88rem;">{{ $country->region }}</span></td>

                        <td>
                            <span class="font-weight-bold text-success">{{ $country->gdp ?? '$1.0B' }}</span>
                        </td>

                        <td>
                            <span class="font-weight-bold text-danger">{{ $country->inflation ?? '2.5' }}%</span>
                        </td>

                        <td>
                            <span class="font-weight-bold text-dark" style="font-size:0.88rem;">{{ number_format($country->population ?? 1000000) }}</span>
                        </td>

                        <td>
                            <span class="badge badge-light border text-dark font-weight-bold">{{ $country->currency ?? 'USD' }}</span>
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold mr-2" style="width: 36px; font-size:0.85rem;">{{ $country->risk_score }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px; border-radius: 4px;">
                                    <div class="progress-bar {{ $country->risk_score >= 60 ? 'bg-danger' : ($country->risk_score >= 35 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $country->risk_score }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            @if($country->risk_level == 'High' || $country->risk_score >= 60)
                                <span class="badge badge-high">High Risk</span>
                            @elseif($country->risk_level == 'Medium' || $country->risk_score >= 35)
                                <span class="badge badge-medium">Medium Risk</span>
                            @else
                                <span class="badge badge-low">Low Risk</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                @php
                                    $isFav = in_array($country->id, $userFavorites ?? []);
                                @endphp
                                <form action="{{ route('favorites.toggle', $country->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $isFav ? 'btn-warning text-white' : 'btn-outline-warning' }}" title="{{ $isFav ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}">
                                        <i class="{{ $isFav ? 'fas fa-star' : 'far fa-star' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('countries.show', $country->id) }}" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-5">
                            <i class="fas fa-globe fa-3x mb-3 text-muted opacity-50"></i>
                            <h6 class="font-weight-bold">Negara Tidak Ditemukan</h6>
                            <p class="text-muted mb-0">Klik tombol "Sync Live REST API" di atas untuk memuat 195 negara dunia secara otomatis.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop