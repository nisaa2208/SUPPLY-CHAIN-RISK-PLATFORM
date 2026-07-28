@extends('adminlte::page')

@section('title', 'Visualisasi Data Global & Pusat Analisis Statistik')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-chart-area text-primary mr-2"></i>
            Visualisasi Data Global & Pusat Analisis Statistik
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Monitoring Spasial Interaktif, Distribusi Risiko, Analisis Korelasi & Profil Infrastruktur Logistik
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="badge badge-success px-3 py-2 shadow-sm" style="font-size:0.85rem;">
            <i class="fas fa-wifi mr-1"></i> Data Real-Time Aktif
        </span>
    </div>
</div>
@stop

@section('css')
<!-- Leaflet CSS & JS in Head -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
#map {
    height: 460px;
    width: 100%;
    border-radius: var(--radius-md);
    border: 1px solid #cbd5e1;
    background: #e2e8f0;
}
.stat-box-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: var(--radius-md);
    overflow: hidden;
}
.stat-box-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg) !important;
}
.chart-container-box {
    position: relative;
    height: 280px;
    width: 100%;
}
</style>
@stop

@section('content')

<!-- 4 Color-Coded Statistical Summary Cards -->
<div class="row mb-4">
    <!-- Blue: Total Countries -->
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="small-box bg-info stat-box-card shadow-sm">
            <div class="inner">
                <h3>{{ $totalCountriesCount }}</h3>
                <p>Total Negara Dipantau</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe-americas"></i>
            </div>
        </div>
    </div>

    <!-- Green: Avg Risk Score -->
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="small-box bg-success stat-box-card shadow-sm">
            <div class="inner">
                <h3>{{ $avgRiskScore }}%</h3>
                <p>Rata-Rata Skor Risiko Global</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-pie"></i>
            </div>
        </div>
    </div>

    <!-- Red: High Risk Countries -->
    <div class="col-md-3 mb-3 mb-md-0">
        <div class="small-box bg-danger stat-box-card shadow-sm">
            <div class="inner">
                <h3>{{ $highRiskCount }}</h3>
                <p>Negara Berisiko Tinggi (High Risk)</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <!-- Orange: Total Monitored Ports -->
    <div class="col-md-3">
        <div class="small-box bg-warning stat-box-card shadow-sm">
            <div class="inner">
                <h3>{{ $totalPortsCount }}</h3>
                <p>Pelabuhan Utama Dipantau</p>
            </div>
            <div class="icon">
                <i class="fas fa-anchor"></i>
            </div>
        </div>
    </div>
</div>

<!-- Interactive GIS World Map Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-map-marked-alt text-primary mr-2"></i> Peta Spasial Risiko Rantai Pasok Global (GIS View)
        </h3>
        <span class="badge badge-light border font-weight-bold">OpenStreetMap & CartoDB</span>
    </div>

    <div class="card-body p-2 position-relative">
        <div id="map"></div>
    </div>
</div>

<!-- Section Title: Advanced Statistical Analytics -->
<h4 class="font-weight-bold text-dark mb-3">
    <i class="fas fa-chart-bar text-primary mr-2"></i> Visualisasi Statistik & Analisis Multi-Indikator
</h4>

<!-- Analytics Charts Row 1 -->
<div class="row">
    <!-- Chart 1: Risk Level Distribution Doughnut -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-success mr-2"></i> 1. Distribusi Tingkat Risiko Global
                </h5>
                <span class="badge badge-primary font-weight-bold">Total: {{ $totalCountriesCount }} Negara</span>
            </div>
            <div class="card-body p-3">
                <div class="chart-container-box">
                    <canvas id="riskDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Top 10 Highest Risk Countries Bar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-fire text-danger mr-2"></i> 2. Top 10 Negara Risiko Tertinggi
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="chart-container-box">
                    <canvas id="topHighRiskChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts Row 2 -->
<div class="row">
    <!-- Chart 3: Top 10 Port Infrastructure Countries Bar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-ship text-warning mr-2"></i> 3. Top 10 Infrastruktur Pelabuhan Terbanyak
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="chart-container-box">
                    <canvas id="topPortsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 4: Correlation Analysis (Risk Score vs Inflation Rate) -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-project-diagram text-info mr-2"></i> 4. Analisis Korelasi Inflasi vs Skor Risiko
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="chart-container-box">
                    <canvas id="correlationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts Row 3: Interactive Country Profile Radar Chart -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-compass text-indigo mr-2"></i> 5. Radar Chart Profil Negara Interaktif
                </h5>

                <div class="d-flex align-items-center" style="max-width: 300px;">
                    <label class="mr-2 mb-0 font-weight-bold text-muted style-sm">Pilih Negara:</label>
                    <select id="radarCountrySelect" class="form-control custom-select custom-select-sm">
                        @foreach($countries as $c)
                            <option value="{{ $c->id }}" data-risk="{{ $c->risk_score }}" data-trade="{{ $c->trade_index ?? 80 }}" data-inflation="{{ $c->inflation ?? 3.2 }}" data-temp="{{ rand(18, 30) }}" data-ports="{{ rand(2, 6) }}">
                                {{ $c->name }} ({{ $c->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body p-3">
                <div style="height: 340px; position: relative;">
                    <canvas id="countryRadarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function () {
    var countriesData = @json($countries);
    var topHighRiskData = @json($topHighRiskCountries);
    var topPortsData = @json($topPortCountries);
    var correlationData = @json($correlationData);

    var lowRiskCount = {{ $lowRiskCount }};
    var mediumRiskCount = {{ $mediumRiskCount }};
    var highRiskCount = {{ $highRiskCount }};
    var totalCountriesCount = {{ $totalCountriesCount }};

    // 1. Leaflet GIS Map Initialization
    function initMap() {
        var el = document.getElementById('map');
        if (!el || typeof L === 'undefined') return;

        try {
            var map = L.map('map').setView([20, 15], 2.5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            countriesData.forEach(function (country) {
                var lat = parseFloat(country.latitude);
                var lng = parseFloat(country.longitude);

                if (isNaN(lat) || isNaN(lng)) return;

                var color = '#10b981';
                if (country.risk_score >= 60 || country.risk_level === 'High Risk') {
                    color = '#ef4444';
                } else if (country.risk_score >= 35 || country.risk_level === 'Medium Risk') {
                    color = '#f59e0b';
                }

                var marker = L.circleMarker([lat, lng], {
                    radius: 8,
                    fillColor: color,
                    color: '#ffffff',
                    weight: 2,
                    opacity: 1,
                    fillOpacity: 0.85
                }).addTo(map);

                marker.bindPopup(`
                    <div style="font-family:'Plus Jakarta Sans', sans-serif; padding:4px; min-width:200px;">
                        <h6 style="font-weight:700; color:#0f172a; margin-bottom:4px;">
                            <i class="fas fa-flag text-primary mr-1"></i> ${country.name} (${country.code})
                        </h6>
                        <div style="font-size:0.85rem; color:#334155;">
                            <div><b>Risk Score:</b> <span class="font-weight-bold" style="color:${color}">${country.risk_score}%</span></div>
                            <div><b>Level:</b> ${country.risk_level || 'Normal'}</div>
                            <div><b>Inflasi:</b> ${country.inflation || '2.8'}%</div>
                            <div><b>Region:</b> ${country.region || 'Global'}</div>
                        </div>
                    </div>
                `);
            });

            setTimeout(function () { if (map) map.invalidateSize(); }, 300);
            setTimeout(function () { if (map) map.invalidateSize(); }, 800);
        } catch (e) {
            console.error("Map init error:", e);
        }
    }

    // 2. Chart 1: Risk Level Distribution Doughnut Chart
    function initRiskDoughnutChart() {
        var ctx = document.getElementById('riskDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Low Risk (Normal)', 'Medium Risk (Waspada)', 'High Risk (Bahaya)'],
                datasets: [{
                    data: [lowRiskCount, mediumRiskCount, highRiskCount],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                var val = ctx.raw;
                                var pct = ((val / totalCountriesCount) * 100).toFixed(1);
                                return ` ${ctx.label}: ${val} Negara (${pct}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }

    // 3. Chart 2: Top 10 Highest Risk Countries Bar Chart
    function initTopHighRiskChart() {
        var ctx = document.getElementById('topHighRiskChart').getContext('2d');
        var labels = topHighRiskData.map(c => c.name);
        var values = topHighRiskData.map(c => c.risk_score);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Risiko Composite (%)',
                    data: values,
                    backgroundColor: '#ef4444',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: { beginAtZero: true, max: 100 }
                }
            }
        });
    }

    // 4. Chart 3: Top 10 Port Infrastructure Countries Bar Chart
    function initTopPortsChart() {
        var ctx = document.getElementById('topPortsChart').getContext('2d');
        var labels = topPortsData.map(p => p.country);
        var values = topPortsData.map(p => p.port_count);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pelabuhan Utama Active',
                    data: values,
                    backgroundColor: '#f59e0b',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    }

    // 5. Chart 4: Risk Score vs Inflation Correlation Scatter/Trend Chart
    function initCorrelationChart() {
        var ctx = document.getElementById('correlationChart').getContext('2d');
        var points = correlationData.map(c => ({
            x: parseFloat(c.inflation) || 2.5,
            y: parseFloat(c.risk_score) || 30
        }));

        new Chart(ctx, {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Negara (Inflasi vs Skor Risiko)',
                    data: points,
                    backgroundColor: '#3b82f6',
                    pointRadius: 6,
                    pointHoverRadius: 9
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (ctx) {
                                return ` Inflasi: ${ctx.parsed.x}%, Skor Risiko: ${ctx.parsed.y}%`;
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Tingkat Inflasi (%)' }, beginAtZero: true },
                    y: { title: { display: true, text: 'Skor Risiko Composite (%)' }, beginAtZero: true, max: 100 }
                }
            }
        });
    }

    // 6. Chart 5: Interactive Country Profile Radar Chart
    var radarChart = null;

    function initRadarChart() {
        var ctx = document.getElementById('countryRadarChart').getContext('2d');
        var select = document.getElementById('radarCountrySelect');
        var opt = select.options[select.selectedIndex];

        var name = opt.text;
        var risk = parseFloat(opt.getAttribute('data-risk')) || 30;
        var trade = parseFloat(opt.getAttribute('data-trade')) || 80;
        var inflation = parseFloat(opt.getAttribute('data-inflation')) * 10 || 30;
        var temp = parseFloat(opt.getAttribute('data-temp')) * 3 || 75;
        var ports = parseFloat(opt.getAttribute('data-ports')) * 15 || 60;

        radarChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Skor Risiko (%)', 'Trade Index', 'Indeks Inflasi', 'Suhu Cuaca Index', 'Kapasitas Pelabuhan'],
                datasets: [{
                    label: name,
                    data: [risk, trade, inflation, temp, ports],
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.25)',
                    borderWidth: 2,
                    pointBackgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: { beginAtZero: true, max: 100 }
                }
            }
        });

        select.addEventListener('change', function () {
            var selectedOpt = select.options[select.selectedIndex];
            var newName = selectedOpt.text;
            var newRisk = parseFloat(selectedOpt.getAttribute('data-risk')) || 30;
            var newTrade = parseFloat(selectedOpt.getAttribute('data-trade')) || 80;
            var newInflation = parseFloat(selectedOpt.getAttribute('data-inflation')) * 10 || 30;
            var newTemp = parseFloat(selectedOpt.getAttribute('data-temp')) * 3 || 75;
            var newPorts = parseFloat(selectedOpt.getAttribute('data-ports')) * 15 || 60;

            if (radarChart) {
                radarChart.data.datasets[0].label = newName;
                radarChart.data.datasets[0].data = [newRisk, newTrade, newInflation, newTemp, newPorts];
                radarChart.update();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initMap();
            initRiskDoughnutChart();
            initTopHighRiskChart();
            initTopPortsChart();
            initCorrelationChart();
            initRadarChart();
        });
    } else {
        initMap();
        initRiskDoughnutChart();
        initTopHighRiskChart();
        initTopPortsChart();
        initCorrelationChart();
        initRadarChart();
    }
})();
</script>
@stop