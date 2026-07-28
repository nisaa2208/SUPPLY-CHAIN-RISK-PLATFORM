@extends('adminlte::page')

@section('title', 'Analisis Risiko Rantai Pasok Global (PDF Spec Hal 4 & 8)')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-0" style="font-size: 1.8rem; color: #0f172a; letter-spacing: -0.02em;">
            <i class="fas fa-shield-alt text-primary mr-2"></i>
            Analisis Risiko Rantai Pasok Global
        </h1>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="badge badge-primary px-3 py-2 shadow-sm" style="font-size:0.85rem;">
            <i class="fas fa-bolt mr-1"></i> Live Scoring Engine
        </span>
    </div>
</div>
@stop

@section('css')
<style>
.formula-banner {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
    color: #ffffff;
    border-radius: var(--radius-md);
    padding: 16px 20px;
    border: 1px solid #312e81;
}
.factor-card {
    border-radius: var(--radius-md);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.factor-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md) !important;
}
.risk-gauge-circle {
    width: 96px;
    height: 96px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-weight: 800;
    box-shadow: 0 4px 14px rgba(0,0,0,0.18);
}
.analytics-table-scroll {
    max-height: 480px;
    overflow-y: auto;
}
.analytics-table-scroll::-webkit-scrollbar {
    width: 6px;
}
.analytics-table-scroll::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
</style>
@stop

@section('content')

<!-- Formula Banner (PDF Spec Hal 4 & 8) -->
<div class="formula-banner shadow-sm mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <span class="badge badge-warning px-3 py-1 font-weight-bold mb-2">FORMULA SPEK PROYEK (HAL 4 & 8)</span>
            <h5 class="font-weight-bold text-white mb-1">
                <i class="fas fa-calculator text-warning mr-2"></i> Algorithm: Weighted Composite Risk Score
            </h5>
            <div style="font-size: 0.95rem; font-family: monospace; color: #cbd5e1;">
                Risk Score = (Weather × 30%) + (Inflation × 20%) + (News Sentiment × 40%) + (Currency × 10%)
            </div>
        </div>
        <div class="mt-2 mt-md-0">
            <span class="badge badge-light px-3 py-2 font-weight-bold text-dark">
                Multi-Factor Dynamic Scoring
            </span>
        </div>
    </div>
</div>

<!-- Interactive Country Risk Scoring Evaluator Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-microchip text-primary mr-2"></i> Evaluator Scoring Risiko Negara Interaktif
        </h4>
        <div style="min-width: 250px;">
            <select id="countryRiskEvaluator" class="form-control custom-select">
                @foreach($allCountries as $c)
                    <option value="{{ $c->id }}" {{ isset($selectedCountry) && $selectedCountry->id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }} ({{ $c->code }})
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="row align-items-center">
            <!-- Left: Composite Risk Gauge Box -->
            <div class="col-md-3 text-center mb-3 mb-md-0 border-right">
                <div class="d-inline-flex flex-column align-items-center">
                    <img id="evalFlag" src="https://flagcdn.com/w160/{{ strtolower($selectedCountry->code ?? 'id') }}.png" class="rounded mb-2 shadow-sm" style="width:64px; height:42px; object-fit:cover;" alt="Flag">
                    <h4 class="font-weight-bold text-dark mb-1" id="evalName">{{ $selectedCountry->name ?? 'Indonesia' }}</h4>
                    <span class="badge badge-light border font-weight-bold mb-3" id="evalRegion">{{ $selectedCountry->region ?? 'Asia' }}</span>

                    <div class="risk-gauge-circle" id="evalGaugeBox" style="background:{{ ($riskCalculation['total_risk'] ?? 30) >= 60 ? '#ef4444' : (($riskCalculation['total_risk'] ?? 30) >= 35 ? '#f59e0b' : '#10b981') }};">
                        <span style="font-size:1.5rem;" id="evalTotalScore">{{ $riskCalculation['total_risk'] ?? 30 }}%</span>
                        <small style="font-size:0.65rem; text-transform:uppercase;">COMPOSITE</small>
                    </div>
                    <span class="badge {{ $riskCalculation['badge_class'] ?? 'badge-success' }} font-weight-bold px-3 py-1 mt-2" id="evalBadge">
                        {{ $riskCalculation['risk_level'] ?? 'Low Risk' }}
                    </span>
                </div>
            </div>

            <!-- Right: 4 Factor Breakdown Cards Grid -->
            <div class="col-md-9">
                <div class="row">
                    <!-- Factor 1: Weather (30%) -->
                    <div class="col-md-6 mb-3">
                        <div class="card factor-card bg-light border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted font-weight-bold d-block">1. RISIKO CUACA & IKLIM (BOBOT 30%)</small>
                                    <h5 class="font-weight-bold text-dark mb-0" id="evalWeatherScore">
                                        {{ $riskCalculation['breakdown']['weather_risk'] ?? 25 }}%
                                    </h5>
                                </div>
                                <span class="badge badge-info p-2 rounded-circle"><i class="fas fa-cloud-sun fa-lg"></i></span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" id="evalWeatherProgress" style="width: {{ $riskCalculation['breakdown']['weather_risk'] ?? 25 }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Factor 2: Inflation (20%) -->
                    <div class="col-md-6 mb-3">
                        <div class="card factor-card bg-light border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted font-weight-bold d-block">2. RISIKO INFLASI & EKONOMI (BOBOT 20%)</small>
                                    <h5 class="font-weight-bold text-dark mb-0" id="evalInflationScore">
                                        {{ $riskCalculation['breakdown']['inflation_risk'] ?? 34 }}%
                                    </h5>
                                </div>
                                <span class="badge badge-danger p-2 rounded-circle"><i class="fas fa-percentage fa-lg"></i></span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-danger" id="evalInflationProgress" style="width: {{ $riskCalculation['breakdown']['inflation_risk'] ?? 34 }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Factor 3: News & Political (40%) -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="card factor-card bg-light border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted font-weight-bold d-block">3. RISIKO BERITA & POLITIK (BOBOT 40%)</small>
                                    <h5 class="font-weight-bold text-dark mb-0" id="evalNewsScore">
                                        {{ $riskCalculation['breakdown']['news_risk'] ?? 35 }}%
                                    </h5>
                                </div>
                                <span class="badge badge-warning p-2 rounded-circle"><i class="fas fa-newspaper fa-lg"></i></span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-warning" id="evalNewsProgress" style="width: {{ $riskCalculation['breakdown']['news_risk'] ?? 35 }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Factor 4: Currency Volatility (10%) -->
                    <div class="col-md-6">
                        <div class="card factor-card bg-light border p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted font-weight-bold d-block">4. RISIKO VOLATILITAS MATA UANG (BOBOT 10%)</small>
                                    <h5 class="font-weight-bold text-dark mb-0" id="evalCurrencyScore">
                                        {{ $riskCalculation['breakdown']['currency_risk'] ?? 20 }}%
                                    </h5>
                                </div>
                                <span class="badge badge-success p-2 rounded-circle"><i class="fas fa-coins fa-lg"></i></span>
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-success" id="evalCurrencyProgress" style="width: {{ $riskCalculation['breakdown']['currency_risk'] ?? 20 }}%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 4 Chart.js Visualizations Grid -->
<div class="row">
    <!-- Chart 1: Risk Level Distribution Doughnut -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-success mr-2"></i> 1. Distribusi Level Risiko Global
                </h5>
            </div>
            <div class="card-body p-3">
                <div style="height: 260px; position: relative;">
                    <canvas id="riskDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 2: Weighted Model Factors Weight Donut -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-donut text-primary mr-2"></i> 2. Proporsi Bobot Algorithm Model (PDF Spek)
                </h5>
            </div>
            <div class="card-body p-3">
                <div style="height: 260px; position: relative;">
                    <canvas id="weightModelChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 3: Top 10 Highest Risk Countries Bar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-exclamation-triangle text-danger mr-2"></i> 3. Top 10 Negara Skor Risiko Tertinggi
                </h5>
            </div>
            <div class="card-body p-3">
                <div style="height: 260px; position: relative;">
                    <canvas id="topRiskBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart 4: Regional Risk Breakdown Radar -->
    <div class="col-md-6 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-globe text-info mr-2"></i> 4. Profil Risiko Rata-Rata Regional
                </h5>
            </div>
            <div class="card-body p-3">
                <div style="height: 260px; position: relative;">
                    <canvas id="regionalRadarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Full Country Risk Matrix Table Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-table text-primary mr-2"></i> Matriks Evaluasi Risiko 195 Negara (Full Database View)
        </h4>

        <div class="d-flex align-items-center gap-2">
            <input type="text" id="matrixSearch" class="form-control form-control-sm mr-2" placeholder="Cari negara..." style="width: 200px;">
            <select id="matrixRegionFilter" class="form-control form-control-sm custom-select" style="width: 150px;">
                <option value="">Semua Wilayah</option>
                <option value="Asia">Asia</option>
                <option value="Europe">Europe</option>
                <option value="Americas">Americas</option>
                <option value="Africa">Africa</option>
                <option value="Oceania">Oceania</option>
            </select>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive analytics-table-scroll">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="40" class="text-center">No</th>
                        <th>Negara</th>
                        <th>Kode</th>
                        <th>Wilayah</th>
                        <th>Skor Risiko Composite</th>
                        <th>Status Level Risiko</th>
                        <th>Inflasi (%)</th>
                        <th width="110" class="text-center">Aksi Evaluasi</th>
                    </tr>
                </thead>

                <tbody id="matrixTableBody">
                    @foreach($allCountries as $c)
                    <tr class="matrix-row" data-name="{{ strtolower($c->name) }}" data-code="{{ strtolower($c->code) }}" data-region="{{ $c->region }}">
                        <td class="text-center text-muted font-weight-bold">{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://flagcdn.com/w160/{{ strtolower($c->code) }}.png" class="mr-2 rounded shadow-sm" style="width:24px; height:16px; object-fit:cover;" alt="Flag">
                                <span class="font-weight-bold text-dark">{{ $c->name }}</span>
                            </div>
                        </td>
                        <td><span class="badge badge-light border font-weight-bold">{{ $c->code }}</span></td>
                        <td><small class="text-muted">{{ $c->region ?? 'Global' }}</small></td>
                        <td>
                            <span class="font-weight-bold" style="color:{{ $c->risk_score >= 60 ? '#ef4444' : ($c->risk_score >= 35 ? '#f59e0b' : '#10b981') }}">
                                {{ $c->risk_score }}%
                            </span>
                        </td>
                        <td>
                            @if($c->risk_score >= 60 || $c->risk_level === 'High Risk')
                                <span class="badge badge-danger font-weight-bold px-2 py-1">High Risk</span>
                            @elseif($c->risk_score >= 35 || $c->risk_level === 'Medium Risk')
                                <span class="badge badge-warning font-weight-bold px-2 py-1">Medium Risk</span>
                            @else
                                <span class="badge badge-success font-weight-bold px-2 py-1">Low Risk</span>
                            @endif
                        </td>
                        <td>{{ $c->inflation ?? '2.8' }}%</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-xs btn-outline-primary font-weight-bold btn-select-eval" data-id="{{ $c->id }}">
                                <i class="fas fa-search mr-1"></i> Evaluasi
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
(function() {
    var lowRiskCount = {{ $lowRiskCount }};
    var mediumRiskCount = {{ $mediumRiskCount }};
    var highRiskCount = {{ $highRiskCount }};

    var topRiskCountries = @json($topRiskCountries);
    var regionalRisks = @json($regionalRisks);

    // 1. Chart 1: Risk Level Distribution Doughnut Chart
    function initRiskDoughnut() {
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
                plugins: { legend: { position: 'bottom' } },
                cutout: '60%'
            }
        });
    }

    // 2. Chart 2: Weighted Scoring Factor Weight Donut (PDF Spec Hal 4 & 8)
    function initWeightModelChart() {
        var ctx = document.getElementById('weightModelChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Berita & Politik (40%)', 'Cuaca & Iklim (30%)', 'Inflasi & Ekonomi (20%)', 'Mata Uang (10%)'],
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#ef4444', '#10b981'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // 3. Chart 3: Top 10 Highest Risk Countries Bar Chart
    function initTopRiskBar() {
        var ctx = document.getElementById('topRiskBarChart').getContext('2d');
        var labels = topRiskCountries.map(c => c.name);
        var values = topRiskCountries.map(c => c.risk_score);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Skor Risiko (%)',
                    data: values,
                    backgroundColor: '#ef4444',
                    borderRadius: 6
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, max: 100 } }
            }
        });
    }

    // 4. Chart 4: Regional Risk Radar Chart
    function initRegionalRadar() {
        var ctx = document.getElementById('regionalRadarChart').getContext('2d');
        var labels = Object.keys(regionalRisks);
        var values = Object.values(regionalRisks);

        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-Rata Skor Risiko (%)',
                    data: values,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.25)',
                    borderWidth: 2,
                    pointBackgroundColor: '#6366f1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { r: { beginAtZero: true, max: 100 } }
            }
        });
    }

    // Interactive Evaluator Change Event
    document.getElementById('countryRiskEvaluator').addEventListener('change', function () {
        var countryId = this.value;
        window.location.href = `{{ url('/analytics') }}?country_id=${countryId}`;
    });

    // Matrix Table Selection Event
    document.querySelectorAll('.btn-select-eval').forEach(btn => {
        btn.addEventListener('click', function () {
            var countryId = this.getAttribute('data-id');
            window.location.href = `{{ url('/analytics') }}?country_id=${countryId}`;
        });
    });

    // Matrix Table Filter & Search
    function filterMatrixTable() {
        var search = document.getElementById('matrixSearch').value.toLowerCase();
        var region = document.getElementById('matrixRegionFilter').value.toLowerCase();

        document.querySelectorAll('.matrix-row').forEach(row => {
            var name = row.getAttribute('data-name');
            var code = row.getAttribute('data-code');
            var reg = row.getAttribute('data-region').toLowerCase();

            var matchesSearch = !search || name.includes(search) || code.includes(search);
            var matchesRegion = !region || reg.includes(region);

            if (matchesSearch && matchesRegion) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    document.getElementById('matrixSearch').addEventListener('keyup', filterMatrixTable);
    document.getElementById('matrixRegionFilter').addEventListener('change', filterMatrixTable);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initRiskDoughnut();
            initWeightModelChart();
            initTopRiskBar();
            initRegionalRadar();
        });
    } else {
        initRiskDoughnut();
        initWeightModelChart();
        initTopRiskBar();
        initRegionalRadar();
    }
})();
</script>
@stop