@extends('adminlte::page')

@section('title', 'World Map')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="mb-0">
        <i class="fas fa-globe-asia text-primary"></i>
        Global Supply Chain World Map
    </h1>
    <div>
        <span class="badge badge-success">🟢 Low</span>
        <span class="badge badge-warning">🟡 Medium</span>
        <span class="badge badge-danger">🔴 High</span>
    </div>
</div>
@stop

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalCountry }}</h3>
                <p>Total Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $lowRisk }}</h3>
                <p>Low Risk</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $mediumRisk }}</h3>
                <p>Medium Risk</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk</p>
            </div>
            <div class="icon">
                <i class="fas fa-radiation"></i>
            </div>
        </div>
    </div>

</div>

<div class="card shadow-sm">

    <div class="card-header bg-primary d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
            <i class="fas fa-map-marked-alt"></i>
            Interactive World Map
        </h3>
        <small class="text-white-50">Click a marker for details</small>
    </div>

    <div class="card-body p-0">

        <div id="loading" class="text-center py-3">
            <i class="fas fa-spinner fa-spin"></i>
            Loading map...
        </div>

        <div id="map" style="height:700px;width:100%;"></div>

    </div>

</div>

@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<style>
    #map { border-radius: 0 0 .25rem .25rem; }
</style>
@stop

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadingEl = document.getElementById('loading');
    const mapEl = document.getElementById('map');
    if (!mapEl) return;

    const map = L.map('map').setView([20, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 18,
    }).addTo(map);

    const markerLayer = L.layerGroup().addTo(map);

    function getColor(riskLevel) {
        if (riskLevel === 'High') return 'red';
        if (riskLevel === 'Medium') return 'orange';
        return 'green';
    }

    function loadMap() {
        if (loadingEl) {
            loadingEl.style.display = 'block';
            loadingEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading map...';
        }

        fetch("{{ route('api.world.map') }}")
            .then(response => response.json())
            .then(data => {
                markerLayer.clearLayers();

                data.forEach(country => {
                    if (country.latitude && country.longitude) {
                        const color = getColor(country.risk_level);

                        const popupHtml = `
                            <div style="min-width:220px">
                                <h5 class="mb-2">🌍 ${country.name ?? '-'}</h5>
                                <hr class="my-2">
                                <div><b>🏛 Capital:</b> ${country.capital ?? '-'}</div>
                                <div><b>🌏 Region:</b> ${country.region ?? '-'}</div>
                                <div><b>⚠ Risk Level:</b> ${country.risk_level ?? '-'}</div>
                                <div><b>📊 Risk Score:</b> ${country.risk_score ?? '-'}</div>
                                <div><b>📈 Trade Index:</b> ${country.trade_index ?? '-'}</div>
                                <div><b>🚢 Shipping:</b> ${country.shipping_status ?? '-'}</div>
                            </div>
                        `;

                        L.circleMarker([country.latitude, country.longitude], {
                            radius: 9,
                            color: color,
                            fillColor: color,
                            fillOpacity: 0.9,
                            weight: 2,
                        })
                        .bindPopup(popupHtml)
                        .addTo(markerLayer);
                    }
                });

                if (loadingEl) loadingEl.style.display = 'none';
            })
            .catch(error => {
                console.log(error);
                if (loadingEl) {
                    loadingEl.innerHTML = '<span class="text-danger">Failed to load map data.</span>';
                }
            });
    }

    loadMap();
    setInterval(loadMap, 30000);
});
</script>
@stop