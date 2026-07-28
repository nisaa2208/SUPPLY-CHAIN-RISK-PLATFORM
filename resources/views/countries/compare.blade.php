@extends('adminlte::page')

@section('title', 'Perbandingan Negara Side-by-Side & AI Intelligence')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-0" style="font-size: 1.75rem;">
            <i class="fas fa-balance-scale text-primary mr-2"></i>
            Perbandingan Negara & AI Supply Chain Intelligence
        </h1>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span class="badge badge-info px-3 py-2 mr-2" style="font-size:0.85rem;">
            <i class="fas fa-microchip mr-1"></i> Multi-API Real-Time Engine
        </span>

        <button id="btnCompareLive" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
            <i class="fas fa-sync-alt mr-1" id="compareSpinner"></i> Bandingkan Real-Time
        </button>
    </div>
</div>
@stop

@section('css')
<style>
.compare-country-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border-radius: var(--radius-md);
    overflow: hidden;
}
.compare-country-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg) !important;
}
.flag-header-img {
    width: 64px;
    height: 44px;
    object-fit: cover;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.risk-circle-box {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.cell-better {
    background-color: #dcfce7 !important;
    color: #166534 !important;
    font-weight: 700;
}
.cell-worse {
    background-color: #fee2e2 !important;
    color: #991b1b !important;
    font-weight: 700;
}
.cell-neutral {
    background-color: #f8fafc;
}
/* Deep Contrast Styling for AI Insight Box */
.card.ai-insight-box {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%) !important;
    color: #ffffff !important;
    border-radius: var(--radius-md);
    border: 1px solid #312e81 !important;
}
.card.ai-insight-box .card-body {
    background: transparent !important;
}
.card.ai-insight-box p {
    color: #f1f5f9 !important;
    font-size: 0.95rem;
    font-weight: 400;
    line-height: 1.6;
}
.card.ai-insight-box .text-warning {
    color: #fbbf24 !important;
}
.card.ai-insight-box .text-info {
    color: #38bdf8 !important;
}
.card.ai-insight-box .text-success {
    color: #4ade80 !important;
}
.inner-ai-panel {
    background: rgba(255, 255, 255, 0.08) !important;
    border: 1px solid rgba(255, 255, 255, 0.15) !important;
    border-radius: 8px;
    padding: 16px;
}
</style>
@stop

@section('content')

<!-- Country Selector Bar -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <label class="font-weight-bold text-dark mb-1"><i class="fas fa-flag text-primary mr-1"></i> Negara Pertama (Negara A):</label>
                <select id="country1Select" class="form-control custom-select">
                    @foreach($allCountries as $c)
                        <option value="{{ $c->id }}" {{ isset($country1) && $country1->id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 text-center mb-2 mb-md-0 d-none d-md-block">
                <div class="rounded-circle bg-light border p-2 d-inline-block shadow-sm" style="width:45px; height:45px;">
                    <i class="fas fa-exchange-alt text-primary font-weight-bold" style="font-size:1.1rem; line-height:27px;"></i>
                </div>
            </div>

            <div class="col-md-5">
                <label class="font-weight-bold text-dark mb-1"><i class="fas fa-flag text-success mr-1"></i> Negara Kedua (Negara B):</label>
                <select id="country2Select" class="form-control custom-select">
                    @foreach($allCountries as $c)
                        <option value="{{ $c->id }}" {{ isset($country2) && $country2->id == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->code }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Friendly Error Alert Container -->
<div id="compareErrorAlert" class="alert alert-warning shadow-sm border-0 d-none mb-4" role="alert">
    <i class="fas fa-exclamation-circle mr-2"></i> <span id="compareErrorMessage">Sebagian data API sedang mengalami hambatan, menampilkan analisis data lokal terbaru.</span>
</div>

<!-- Side-by-Side Country Cards Row -->
<div class="row mb-4">
    <!-- Country A Card -->
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="card compare-country-card border-0 shadow-sm h-100" style="background:#f0fdf4;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img id="c1Flag" src="https://flagcdn.com/w160/{{ strtolower($country1->code ?? 'id') }}.png" class="flag-header-img mr-3" alt="Flag">
                        <div>
                            <span class="badge badge-light border font-weight-bold text-muted" id="c1Code">{{ $country1->code ?? 'ID' }}</span>
                            <h3 class="font-weight-bold text-dark mb-0 mt-1" id="c1Name">{{ $country1->name ?? 'Indonesia' }}</h3>
                            <small class="text-muted" id="c1Region">{{ $country1->region ?? 'Asia' }}</small>
                        </div>
                    </div>

                    <div class="risk-circle-box" id="c1RiskBox" style="background:#10b981;">
                        <span style="font-size:1.3rem;" id="c1RiskScore">{{ $country1->risk_score ?? 25 }}%</span>
                        <small style="font-size:0.65rem; text-transform:uppercase;">SKOR RISIKO</small>
                    </div>
                </div>

                <div class="row pt-2 border-top">
                    <div class="col-6 mb-2">
                        <small class="text-muted font-weight-bold d-block">MATA UANG</small>
                        <span class="font-weight-bold text-dark" id="c1Currency">{{ $country1->currency ?? 'IDR' }}</span>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted font-weight-bold d-block">JUMLAH PELABUHAN</small>
                        <span class="font-weight-bold text-primary" id="c1Ports">3 Pelabuhan</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted font-weight-bold d-block">CUACA REAL-TIME</small>
                        <span class="font-weight-bold text-dark" id="c1Weather">28.5°C (Cerah)</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted font-weight-bold d-block">STATUS RISIKO</small>
                        <span class="badge badge-success font-weight-bold" id="c1RiskBadge">Low Risk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Country B Card -->
    <div class="col-md-6">
        <div class="card compare-country-card border-0 shadow-sm h-100" style="background:#eff6ff;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img id="c2Flag" src="https://flagcdn.com/w160/{{ strtolower($country2->code ?? 'de') }}.png" class="flag-header-img mr-3" alt="Flag">
                        <div>
                            <span class="badge badge-light border font-weight-bold text-muted" id="c2Code">{{ $country2->code ?? 'DE' }}</span>
                            <h3 class="font-weight-bold text-dark mb-0 mt-1" id="c2Name">{{ $country2->name ?? 'Germany' }}</h3>
                            <small class="text-muted" id="c2Region">{{ $country2->region ?? 'Europe' }}</small>
                        </div>
                    </div>

                    <div class="risk-circle-box" id="c2RiskBox" style="background:#10b981;">
                        <span style="font-size:1.3rem;" id="c2RiskScore">{{ $country2->risk_score ?? 18 }}%</span>
                        <small style="font-size:0.65rem; text-transform:uppercase;">SKOR RISIKO</small>
                    </div>
                </div>

                <div class="row pt-2 border-top">
                    <div class="col-6 mb-2">
                        <small class="text-muted font-weight-bold d-block">MATA UANG</small>
                        <span class="font-weight-bold text-dark" id="c2Currency">{{ $country2->currency ?? 'EUR' }}</span>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted font-weight-bold d-block">JUMLAH PELABUHAN</small>
                        <span class="font-weight-bold text-primary" id="c2Ports">2 Pelabuhan</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted font-weight-bold d-block">CUACA REAL-TIME</small>
                        <span class="font-weight-bold text-dark" id="c2Weather">18.2°C (Cerah Berawan)</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted font-weight-bold d-block">STATUS RISIKO</small>
                        <span class="badge badge-success font-weight-bold" id="c2RiskBadge">Low Risk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Side-by-Side Comparative Matrix Table Card -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-table text-primary mr-2"></i> Matriks Perbandingan Parameter Metrik Real-Time
        </h4>
        <span class="badge badge-light border font-weight-bold">Contextual Highlight</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 align-middle">
                <thead class="thead-light text-center">
                    <tr>
                        <th width="30%">Parameter Metrik</th>
                        <th width="35%" id="thC1Name">{{ $country1->name ?? 'Negara A' }}</th>
                        <th width="35%" id="thC2Name">{{ $country2->name ?? 'Negara B' }}</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-shield-alt text-primary mr-2"></i> Skor Risiko Logistik Composite</td>
                        <td class="text-center" id="cellRiskScore1">25%</td>
                        <td class="text-center" id="cellRiskScore2">18%</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-signal text-warning mr-2"></i> Status Tingkat Risiko</td>
                        <td class="text-center" id="cellRiskLevel1"><span class="badge badge-success">Low Risk</span></td>
                        <td class="text-center" id="cellRiskLevel2"><span class="badge badge-success">Low Risk</span></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-chart-line text-success mr-2"></i> Trade Readiness Index</td>
                        <td class="text-center" id="cellTrade1">88 / 100</td>
                        <td class="text-center" id="cellTrade2">95 / 100</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-percentage text-danger mr-2"></i> Tingkat Inflasi Tahunan</td>
                        <td class="text-center" id="cellInflation1">2.84%</td>
                        <td class="text-center" id="cellInflation2">2.90%</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-cloud-sun text-info mr-2"></i> Suhu & Cuaca Real-Time (Open-Meteo)</td>
                        <td class="text-center" id="cellWeather1">28.5°C (Cerah)</td>
                        <td class="text-center" id="cellWeather2">18.2°C (Berawan)</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-coins text-warning mr-2"></i> Nilai Tukar per 1 USD (ExchangeRate API)</td>
                        <td class="text-center" id="cellExchange1">15,650 IDR</td>
                        <td class="text-center" id="cellExchange2">0.92 EUR</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-anchor text-primary mr-2"></i> Infrastruktur Pelabuhan Utama</td>
                        <td class="text-center" id="cellPorts1">3 Pelabuhan Active</td>
                        <td class="text-center" id="cellPorts2">2 Pelabuhan Active</td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold text-dark"><i class="fas fa-shipping-fast text-secondary mr-2"></i> Status Pengiriman Maritim</td>
                        <td class="text-center" id="cellShipping1">Normal</td>
                        <td class="text-center" id="cellShipping2">Normal</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js Side-by-Side Visual Comparison Graphs -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-chart-bar text-primary mr-2"></i> Visualisasi Grafik Komparatif Side-by-Side (Chart.js)
        </h4>
    </div>
    <div class="card-body p-3">
        <div style="height: 320px; position: relative;">
            <canvas id="compareBarChart"></canvas>
        </div>
    </div>
</div>

<!-- Dynamic AI Supply Chain Intelligence Insight Card -->
<div class="card ai-insight-box shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="font-weight-bold text-white mb-0">
                <i class="fas fa-robot text-warning mr-2"></i> AI Supply Chain Intelligence Insight
            </h4>
            <span class="badge badge-info px-3 py-2" style="font-size:0.82rem; background:rgba(255,255,255,0.15); border:1px solid rgba(255,255,255,0.3); color:#ffffff !important;">
                <i class="fas fa-microchip mr-1"></i> Analisis berdasarkan data real-time Multi-API
            </span>
        </div>

        <div class="inner-ai-panel mb-3">
            <h6 class="font-weight-bold text-warning mb-2"><i class="fas fa-file-alt mr-1"></i> Ringkasan Eksekutif Perbandingan:</h6>
            <p class="mb-0 text-white" id="aiSummaryText">
                Berdasarkan integrasi data real-time Multi-API (REST Countries, Open-Meteo Weather, ExchangeRate API & GIS Pelabuhan), negara dengan stabilitas tertinggi akan direkomendasikan sebagai hub distribusi.
            </p>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="inner-ai-panel h-100">
                    <h6 class="font-weight-bold text-info mb-2"><i class="fas fa-exclamation-triangle mr-1"></i> Faktor Utama Penyebab Risiko:</h6>
                    <p class="mb-0 text-white" id="aiDriversText">
                        Mengukur perbedaan inflasi, suhu cuaca maritim, dan ketersediaan kapasitas pelabuhan kontainer.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="inner-ai-panel h-100">
                    <h6 class="font-weight-bold text-success mb-2"><i class="fas fa-route mr-1"></i> Rekomendasi Rute & Hub Logistik:</h6>
                    <p class="mb-0 text-white" id="aiRouteText">
                        Rekomendasi rute logistik maritim optimal berdasarkan data terbaru.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let compareChart = null;

    // Helper to convert **text** to <strong>text</strong>
    function formatMarkdown(text) {
        if (!text) return '';
        return text.replace(/\*\*(.*?)\*\*/g, '<strong style="color:#ffffff; font-weight:700;">$1</strong>');
    }

    // Initialize Chart.js
    function initChart() {
        const ctx = document.getElementById('compareBarChart').getContext('2d');
        compareChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Skor Risiko (%)', 'Trade Index', 'Inflasi (%)', 'Suhu Cuaca (°C)', 'Kapasitas Pelabuhan'],
                datasets: [
                    {
                        label: 'Negara A',
                        data: [25, 88, 2.84, 28.5, 3],
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Negara B',
                        data: [18, 95, 2.90, 18.2, 2],
                        backgroundColor: '#3b82f6',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    initChart();

    // Fetch Live Comparison Data via AJAX
    function fetchLiveCompare() {
        const c1Id = document.getElementById('country1Select').value;
        const c2Id = document.getElementById('country2Select').value;

        document.getElementById('compareSpinner').classList.add('fa-spin');
        document.getElementById('compareErrorAlert').classList.add('d-none');

        const params = new URLSearchParams({ country1_id: c1Id, country2_id: c2Id });

        fetch(`{{ url('/api/countries/compare/live') }}?${params.toString()}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('compareSpinner').classList.remove('fa-spin');

                if (res.success && res.country1 && res.country2) {
                    updateUI(res.country1, res.country2, res.ai_analysis);
                } else {
                    showError('Sebagian data API belum tersedia, silakan coba kembali.');
                }
            })
            .catch(err => {
                document.getElementById('compareSpinner').classList.remove('fa-spin');
                showError('Sebagian data API belum tersedia, silakan coba kembali.');
            });
    }

    // Update Entire Page UI
    function updateUI(c1, c2, ai) {
        // 1. Cards Country A
        document.getElementById('c1Name').innerText = c1.name;
        document.getElementById('c1Code').innerText = c1.code;
        document.getElementById('c1Region').innerText = c1.region;
        document.getElementById('c1Flag').src = c1.flag_url;
        document.getElementById('c1RiskScore').innerText = c1.risk_score + '%';
        document.getElementById('c1RiskBox').style.background = c1.risk_color;
        document.getElementById('c1Currency').innerText = c1.currency;
        document.getElementById('c1Ports').innerText = c1.port_count + ' Pelabuhan';
        document.getElementById('c1Weather').innerText = c1.temperature + '°C (' + c1.weather_text + ')';
        document.getElementById('c1RiskBadge').innerText = c1.risk_level;
        document.getElementById('c1RiskBadge').className = 'badge ' + c1.risk_badge + ' font-weight-bold';

        // 2. Cards Country B
        document.getElementById('c2Name').innerText = c2.name;
        document.getElementById('c2Code').innerText = c2.code;
        document.getElementById('c2Region').innerText = c2.region;
        document.getElementById('c2Flag').src = c2.flag_url;
        document.getElementById('c2RiskScore').innerText = c2.risk_score + '%';
        document.getElementById('c2RiskBox').style.background = c2.risk_color;
        document.getElementById('c2Currency').innerText = c2.currency;
        document.getElementById('c2Ports').innerText = c2.port_count + ' Pelabuhan';
        document.getElementById('c2Weather').innerText = c2.temperature + '°C (' + c2.weather_text + ')';
        document.getElementById('c2RiskBadge').innerText = c2.risk_level;
        document.getElementById('c2RiskBadge').className = 'badge ' + c2.risk_badge + ' font-weight-bold';

        // 3. Table Headers
        document.getElementById('thC1Name').innerText = c1.name;
        document.getElementById('thC2Name').innerText = c2.name;

        // 4. Table Contextual Highlights
        setCellHighlight('cellRiskScore1', 'cellRiskScore2', c1.risk_score + '%', c2.risk_score + '%', c1.risk_score <= c2.risk_score);

        document.getElementById('cellRiskLevel1').innerHTML = `<span class="badge ${c1.risk_badge}">${c1.risk_level}</span>`;
        document.getElementById('cellRiskLevel2').innerHTML = `<span class="badge ${c2.risk_badge}">${c2.risk_level}</span>`;

        setCellHighlight('cellTrade1', 'cellTrade2', c1.trade_index + ' / 100', c2.trade_index + ' / 100', c1.trade_index >= c2.trade_index);
        setCellHighlight('cellInflation1', 'cellInflation2', c1.inflation + '%', c2.inflation + '%', c1.inflation <= c2.inflation);

        document.getElementById('cellWeather1').innerText = `${c1.temperature}°C (${c1.weather_text})`;
        document.getElementById('cellWeather2').innerText = `${c2.temperature}°C (${c2.weather_text})`;

        document.getElementById('cellExchange1').innerText = `${c1.exchange_rate} ${c1.currency}`;
        document.getElementById('cellExchange2').innerText = `${c2.exchange_rate} ${c2.currency}`;

        setCellHighlight('cellPorts1', 'cellPorts2', c1.port_count + ' Pelabuhan Active', c2.port_count + ' Pelabuhan Active', c1.port_count >= c2.port_count);

        document.getElementById('cellShipping1').innerText = c1.shipping_status;
        document.getElementById('cellShipping2').innerText = c2.shipping_status;

        // 5. Chart.js Update
        if (compareChart) {
            compareChart.data.datasets[0].label = c1.name;
            compareChart.data.datasets[0].data = [c1.risk_score, c1.trade_index, c1.inflation, c1.temperature, c1.port_count];
            compareChart.data.datasets[0].backgroundColor = c1.risk_color;

            compareChart.data.datasets[1].label = c2.name;
            compareChart.data.datasets[1].data = [c2.risk_score, c2.trade_index, c2.inflation, c2.temperature, c2.port_count];
            compareChart.data.datasets[1].backgroundColor = c2.risk_color;

            compareChart.update();
        }

        // 6. AI Insights Update
        if (ai) {
            document.getElementById('aiSummaryText').innerHTML = formatMarkdown(ai.summary);
            document.getElementById('aiDriversText').innerHTML = formatMarkdown(ai.risk_drivers);
            document.getElementById('aiRouteText').innerHTML = formatMarkdown(ai.optimal_route);
        }
    }

    function setCellHighlight(id1, id2, val1, val2, isFirstBetter) {
        const el1 = document.getElementById(id1);
        const el2 = document.getElementById(id2);

        el1.innerText = val1;
        el2.innerText = val2;

        if (isFirstBetter) {
            el1.className = 'text-center cell-better';
            el2.className = 'text-center cell-worse';
        } else {
            el1.className = 'text-center cell-worse';
            el2.className = 'text-center cell-better';
        }
    }

    function showError(msg) {
        document.getElementById('compareErrorMessage').innerText = msg;
        document.getElementById('compareErrorAlert').classList.remove('d-none');
    }

    // Event Listeners
    document.getElementById('btnCompareLive').addEventListener('click', fetchLiveCompare);
    document.getElementById('country1Select').addEventListener('change', fetchLiveCompare);
    document.getElementById('country2Select').addEventListener('change', fetchLiveCompare);

    // Initial Fetch
    fetchLiveCompare();
});
</script>
@stop
