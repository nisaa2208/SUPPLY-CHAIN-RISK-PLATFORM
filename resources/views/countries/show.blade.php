@extends('adminlte::page')

@section('title', 'Detail Profil Negara - ' . $country->name)

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-flag text-primary mr-2"></i>
            Profil Negara: {{ $country->name }} ({{ $country->code }})
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Analisis Komprehensif Risiko Berdaulat, Indikator Ekonomi & Jalur Logistik Maritim
        </div>
    </div>

    <div class="d-flex gap-2">
        <form action="{{ route('favorites.toggle', $country->id) }}" method="POST" class="d-inline mr-2">
            @csrf
            <button type="submit" class="btn {{ ($isFavorited ?? false) ? 'btn-warning text-white' : 'btn-outline-warning' }} shadow-sm font-weight-bold">
                <i class="{{ ($isFavorited ?? false) ? 'fas fa-star' : 'far fa-star' }} mr-1"></i>
                {{ ($isFavorited ?? false) ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}
            </button>
        </form>

        <a href="{{ route('countries.index') }}" class="btn btn-secondary shadow-sm mr-2 font-weight-bold">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Daftar
        </a>

        <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-warning shadow-sm font-weight-bold">
            <i class="fas fa-edit mr-1"></i> Edit Negara
        </a>
    </div>
</div>
@stop

@section('content')

<!-- Header Banner Card -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4 bg-gradient-primary text-white" style="border-radius: var(--radius-md);">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge badge-light text-primary font-weight-bold px-3 py-1 mb-2">{{ $country->region }}</span>
                <h2 class="font-weight-bold text-white mb-2">{{ $country->name }}</h2>
                <p class="mb-0 text-light" style="font-size:0.95rem;">
                    <i class="fas fa-map-marker-alt text-warning mr-1"></i> Koordinat Spasial: {{ $country->latitude ?? '-' }}, {{ $country->longitude ?? '-' }} |
                    <i class="fas fa-coins text-warning ml-2 mr-1"></i> Mata Uang: <strong>{{ $country->currency ?? 'USD' }}</strong>
                </p>
            </div>

            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <div class="p-3 bg-white rounded text-center shadow-sm d-inline-block" style="min-width: 180px;">
                    <span class="text-muted font-weight-bold d-block" style="font-size: 0.8rem;">COMPOSITE RISK SCORE</span>
                    <div class="display-4 font-weight-bold text-primary mb-0">{{ $country->risk_score }}%</div>
                    <span class="badge {{ $country->risk_color == 'danger' ? 'badge-danger' : ($country->risk_color == 'warning' ? 'badge-warning' : 'badge-success') }} px-3 py-1 font-weight-bold mt-1">
                        {{ $country->risk_level }} Risk
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Economic & Logistics Indicators -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-primary mr-2"></i> Indikator Ekonomi & Perdagangan Global
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="row text-center mb-4">
                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded bg-light border">
                            <i class="fas fa-building fa-2x text-primary mb-2"></i>
                            <div class="h5 font-weight-bold text-dark mb-0">{{ $country->gdp ?? '$1.2T' }}</div>
                            <small class="text-muted font-weight-bold">Estimasi GDP</small>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 mb-3 mb-md-0">
                        <div class="p-3 rounded bg-light border">
                            <i class="fas fa-percentage fa-2x text-danger mb-2"></i>
                            <div class="h5 font-weight-bold text-danger mb-0">{{ $country->inflation ?? '2.5' }}%</div>
                            <small class="text-muted font-weight-bold">Tingkat Inflasi</small>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="p-3 rounded bg-light border">
                            <i class="fas fa-users fa-2x text-info mb-2"></i>
                            <div class="h5 font-weight-bold text-dark mb-0">{{ number_format($country->population ?? 50000000) }}</div>
                            <small class="text-muted font-weight-bold">Populasi</small>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <div class="p-3 rounded bg-light border">
                            <i class="fas fa-exchange-alt fa-2x text-success mb-2"></i>
                            <div class="h5 font-weight-bold text-dark mb-0">{{ $country->trade_index }}/100</div>
                            <small class="text-muted font-weight-bold">Trade Index</small>
                        </div>
                    </div>
                </div>

                <h5 class="font-weight-bold text-dark mb-3 border-bottom pb-2">
                    <i class="fas fa-shipping-fast text-warning mr-2"></i> Status Rantai Pasok & Logistik
                </h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="p-3 rounded border bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">STATUS PENGIRIMAN MARITIM</small>
                                <strong class="text-dark">{{ $country->shipping_status }}</strong>
                            </div>
                            <div>
                                @if($country->shipping_status == 'Critical')
                                    <span class="badge badge-danger px-3 py-2 font-weight-bold">Critical Disruption</span>
                                @elseif($country->shipping_status == 'Delayed')
                                    <span class="badge badge-warning px-3 py-2 font-weight-bold">Port Delays</span>
                                @else
                                    <span class="badge badge-success px-3 py-2 font-weight-bold">Normal Operations</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="p-3 rounded border bg-light d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block font-weight-bold">STATUS PASOKAN BARANG</small>
                                <strong class="text-dark">{{ $country->supply_status ?? 'Normal' }}</strong>
                            </div>
                            <div>
                                <span class="badge badge-info px-3 py-2 font-weight-bold">{{ $country->supply_status ?? 'Normal' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Connected Entities (Suppliers & Products) -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-boxes text-primary mr-2"></i> Entitas Pemasok & Produk Terkait
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="row text-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="p-3 rounded border bg-light">
                            <i class="fas fa-industry fa-2x text-primary mb-2"></i>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $country->suppliers()->count() }}</h3>
                            <span class="text-muted font-weight-bold">Supplier Terdaftar di {{ $country->name }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 rounded border bg-light">
                            <i class="fas fa-box fa-2x text-warning mb-2"></i>
                            <h3 class="font-weight-bold text-dark mb-1">{{ $country->products()->count() }}</h3>
                            <span class="text-muted font-weight-bold">Produk Diimpor dari {{ $country->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata & Location Map -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-map-marked-alt text-danger mr-2"></i> Lokasi Geografis
                </h4>
            </div>
            <div class="card-body p-2">
                @if($country->latitude && $country->longitude)
                <div id="countryMap" style="height: 260px; border-radius: var(--radius-sm);"></div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-map-marker-slash fa-2x mb-2 d-block"></i>
                    Koordinat GPS belum diatur.
                </div>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-info-circle text-info mr-2"></i> Metadata Sistem
                </h4>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush" style="font-size:0.88rem;">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">ID Negara</span>
                        <strong class="text-dark">#{{ $country->id }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Kode ISO</span>
                        <strong class="badge badge-light border text-dark">{{ $country->code }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Didaftarkan Pada</span>
                        <strong class="text-dark">{{ $country->created_at->format('d M Y H:i') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Pembaruan Terakhir</span>
                        <strong class="text-dark">{{ $country->updated_at->format('d M Y H:i') }}</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
@if($country->latitude && $country->longitude)
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script>
document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('countryMap', { zoomControl: false }).setView([{{ $country->latitude }}, {{ $country->longitude }}], 5);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
        attribution: '&copy; CARTO'
    }).addTo(map);

    L.marker([{{ $country->latitude }}, {{ $country->longitude }}]).addTo(map)
        .bindPopup("<b>{{ $country->name }}</b><br>Risk Score: {{ $country->risk_score }}%")
        .openPopup();
});
</script>
@endif
@stop