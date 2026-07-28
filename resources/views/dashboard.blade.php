@extends('adminlte::page')

@section('title', 'Global Country Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-shield-alt text-primary mr-2"></i>
            Global Supply Chain Risk Intelligence Dashboard
        </h1>
        <div class="text-muted d-flex align-items-center" style="font-size: 0.88rem;">
            <span class="live-dot mr-2"></span> Multi-API Real-Time Risk Analytics & Decision Support Platform
        </div>
    </div>

    <div class="d-flex align-items-center">
        <div id="liveClock" class="badge badge-primary px-3 py-2 mr-3" style="font-size:0.85rem; font-weight:600; border-radius: 20px;">
        </div>

        <a href="{{ route('dashboard') }}" class="btn btn-success btn-sm shadow-sm">
            <i class="fas fa-sync-alt mr-1"></i> Refresh
        </a>
    </div>
</div>
@stop

@section('content')

<!-- Global Country Selection & Economic Risk Dashboard (PDF Hal 4) -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-gradient-primary text-white py-3">
        <h3 class="card-title font-weight-bold mb-0">
            <i class="fas fa-globe-americas mr-2"></i> Global Country Dashboard & Risk Engine
        </h3>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('dashboard') }}" method="GET" class="mb-4">
            <div class="row align-items-center">
                <div class="col-md-9 mb-2 mb-md-0">
                    <label class="font-weight-bold text-dark mb-1"><i class="fas fa-flag text-primary mr-1"></i> Pilih Negara untuk Dipantau (Contoh: Germany, China, Indonesia, Australia):</label>
                    <select name="country_id" class="form-control form-control-lg custom-select" onchange="this.form.submit()">
                        @foreach($allCountries as $c)
                            <option value="{{ $c->id }}" {{ optional($selectedCountry)->id == $c->id ? 'selected' : '' }}>
                                {{ $c->name }} ({{ $c->code }}) — {{ $c->region }} [Risk Score: {{ $c->risk_score }}%]
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block shadow-sm">
                        <i class="fas fa-search mr-1"></i> Analisis Negara
                    </button>
                </div>
            </div>
        </form>

        @if($selectedCountry)
        <div class="row">
            <!-- Selected Country Metrics (GDP, Inflation, Population, Currency) -->
            <div class="col-md-8">
                <div class="card border bg-light h-100 p-3" style="border-radius: var(--radius-md);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="font-weight-bold text-dark mb-0">
                            <i class="fas fa-building text-primary mr-2"></i> {{ $selectedCountry->name }} ({{ $selectedCountry->code }})
                        </h4>
                        <span class="badge {{ $selectedCountry->risk_color == 'danger' ? 'badge-danger' : ($selectedCountry->risk_color == 'warning' ? 'badge-warning' : 'badge-success') }} px-3 py-2 font-weight-bold">
                            {{ $selectedCountry->risk_level }} Risk
                        </span>
                    </div>

                    <div class="row text-center mb-3">
                        <div class="col-6 col-md-3 mb-2 mb-md-0">
                            <div class="p-3 bg-white rounded border">
                                <small class="text-muted font-weight-bold d-block">GDP</small>
                                <strong class="text-primary font-weight-bold" style="font-size:1.1rem;">{{ $selectedCountry->gdp ?? '$1.2T' }}</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3 mb-2 mb-md-0">
                            <div class="p-3 bg-white rounded border">
                                <small class="text-muted font-weight-bold d-block">Inflasi</small>
                                <strong class="text-danger font-weight-bold" style="font-size:1.1rem;">{{ $selectedCountry->inflation ?? '2.5' }}%</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-white rounded border">
                                <small class="text-muted font-weight-bold d-block">Populasi</small>
                                <strong class="text-dark font-weight-bold" style="font-size:1.1rem;">{{ number_format($selectedCountry->population ?? 10000000) }}</strong>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-white rounded border">
                                <small class="text-muted font-weight-bold d-block">Mata Uang</small>
                                <strong class="text-success font-weight-bold" style="font-size:1.1rem;">{{ $selectedCountry->currency ?? 'USD' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top text-muted" style="font-size:0.85rem;">
                        <span><i class="fas fa-globe mr-1"></i> Region: <strong>{{ $selectedCountry->region }}</strong></span>
                        <span><i class="fas fa-ship mr-1"></i> Status Logistik: <strong class="text-dark">{{ $selectedCountry->shipping_status }}</strong></span>
                        <span><i class="fas fa-chart-line mr-1"></i> Trade Index: <strong>{{ $selectedCountry->trade_index }}/100</strong></span>
                    </div>
                </div>
            </div>

            <!-- Risk Scoring Engine Output (PDF Hal 4 & 8) -->
            <div class="col-md-4">
                <div class="card border bg-dark text-white h-100 p-3 shadow-sm" style="border-radius: var(--radius-md);">
                    <h5 class="font-weight-bold mb-2 text-warning">
                        <i class="fas fa-calculator mr-2"></i> Risk Scoring Engine
                    </h5>
                    <small class="text-light mb-3 d-block">Algoritma Weighted Risk Prediction Model:</small>

                    @if($riskCalculation)
                    <div class="text-center mb-3">
                        <div class="display-4 font-weight-bold text-white mb-0">{{ $riskCalculation['total_risk'] }}%</div>
                        <span class="badge {{ $riskCalculation['badge_class'] }} px-3 py-1 mt-1 font-weight-bold">
                            {{ $selectedCountry->name }} : {{ $riskCalculation['total_risk'] }} ({{ $riskCalculation['risk_level'] }})
                        </span>
                    </div>

                    <div style="font-size: 0.8rem;" class="bg-secondary p-2 rounded mb-2">
                        <div class="d-flex justify-content-between"><span>Weather Risk (30%):</span> <strong>{{ $riskCalculation['breakdown']['weather_risk'] }}%</strong></div>
                        <div class="d-flex justify-content-between"><span>Inflation Risk (20%):</span> <strong>{{ $riskCalculation['breakdown']['inflation_risk'] }}%</strong></div>
                        <div class="d-flex justify-content-between"><span>News Sentiment (40%):</span> <strong>{{ $riskCalculation['breakdown']['news_risk'] }}%</strong></div>
                        <div class="d-flex justify-content-between"><span>Currency Risk (10%):</span> <strong>{{ $riskCalculation['breakdown']['currency_risk'] }}%</strong></div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Stat Metrics Cards Row -->
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $countries }}</h3>
                <p>Total Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $suppliers }}</h3>
                <p>Total Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $products }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet World Map & Top Risk Table -->
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-map-marked-alt text-primary mr-2"></i>
                    Global Risk Interactive Geospatial Map
                </h3>
            </div>
            <div class="card-body p-2">
                <div id="worldMap" style="height:480px; border-radius: var(--radius-md);"></div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-exclamation-circle text-danger mr-2"></i>
                    Top High Risk Countries
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($topRiskCountries as $c)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong class="text-dark">{{ $c->name }}</strong>
                                <small class="text-muted d-block">{{ $c->region }}</small>
                            </div>
                            <span class="badge {{ $c->risk_score >= 60 ? 'badge-danger' : 'badge-warning' }} px-3 py-2 font-weight-bold">
                                {{ $c->risk_score }}% Risk
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No high risk countries</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Live Clock
    setInterval(function () {
        const now = new Date();
        document.getElementById('liveClock').innerText = now.toLocaleTimeString() + ' | ' + now.toLocaleDateString();
    }, 1000);

    // Leaflet World Map
    var map = L.map('worldMap').setView([20, 10], 2);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
        attribution: '&copy; CARTO'
    }).addTo(map);

    @foreach($mapCountries as $country)
    @if($country->latitude && $country->longitude)
    (function() {
        var color = 'green';
        @if($country->risk_score >= 60)
            color = 'red';
        @elseif($country->risk_score >= 35)
            color = 'orange';
        @endif

        L.circleMarker([{{ $country->latitude }}, {{ $country->longitude }}], {
            radius: 8,
            color: color,
            fillColor: color,
            fillOpacity: 0.8
        }).addTo(map).bindPopup(`
            <div style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <strong>${'{{ $country->name }}'}</strong><br>
                Risk Score: <strong>${'{{ $country->risk_score }}'}%</strong><br>
                GDP: ${'{{ $country->gdp ?? "-" }}'}<br>
                Inflasi: ${'{{ $country->inflation ?? "-" }}'}%
            </div>
        `);
    })();
    @endif
    @endforeach
});
</script>
@stop