@extends('adminlte::page')

@section('title', 'Currency Impact Dashboard Real-Time')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-coins text-success mr-2"></i>
            Currency Impact Dashboard Real-Time
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Live Exchange Rates API, Base Currency Selector, Import Calculator & Chart.js Trend Visualizations
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button id="btnRefreshExchange" class="btn btn-success btn-sm shadow-sm font-weight-bold">
            <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh Rates
        </button>
    </div>
</div>
@stop

@section('content')

<!-- Base Currency Selector Bar -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-8 mb-2 mb-md-0">
                <label class="font-weight-bold text-dark mb-0 mr-3"><i class="fas fa-money-bill-wave text-success mr-1"></i> Pilih Mata Uang Utama (Base Currency):</label>
            </div>
            <div class="col-md-4">
                <select id="baseCurrencySelect" class="form-control custom-select">
                    <option value="USD" selected>🇺🇸 USD — Dolar Amerika Serikat</option>
                    <option value="EUR">🇪🇺 EUR — Euro Eropa</option>
                    <option value="GBP">🇬🇧 GBP — Poundsterling Inggris</option>
                    <option value="IDR">🇮🇩 IDR — Rupiah Indonesia</option>
                    <option value="JPY">🇯🇵 JPY — Yen Jepang</option>
                    <option value="SGD">🇸🇬 SGD — Dolar Singapura</option>
                    <option value="CNY">🇨🇳 CNY — Yuan China</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Major Foreign Exchange Rate Cards Row -->
<div class="row" id="rateCardsRow">
    <!-- Dynamic Cards Rendered via JS -->
</div>

<!-- Chart.js Currency Trend & Converter Section (PDF Spec Hal 5) -->
<div class="row">
    <!-- Chart.js Currency Trend Graph -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-bar text-success mr-2"></i> Grafik Perubahan Kurs (Chart.js)
                </h4>
                <span class="badge badge-light border font-weight-bold" id="chartBaseLabel">Base: USD</span>
            </div>
            <div class="card-body p-3">
                <div style="height: 280px; position: relative;">
                    <canvas id="currencyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Trade Currency Calculator -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-gradient-success text-white py-3">
                <h4 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-calculator mr-2"></i> Kalkulator Impor & Konversi Kurs
                </h4>
            </div>
            <div class="card-body p-4">
                <div class="form-group">
                    <label class="font-weight-bold text-dark"><i class="fas fa-dollar-sign text-success mr-1"></i> Jumlah Anggaran (<span id="calcBaseLabel">USD</span>):</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white font-weight-bold" id="calcBaseSymbol">$</span>
                        </div>
                        <input type="number" id="calcUsdInput" class="form-control form-control-lg" value="1000" min="1" step="100">
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold text-dark"><i class="fas fa-coins text-warning mr-1"></i> Mata Uang Target Impor:</label>
                    <select id="calcTargetSelect" class="form-control form-control-lg custom-select">
                        <!-- Options filled dynamically -->
                    </select>
                </div>

                <div class="p-3 bg-light rounded border text-center mt-4">
                    <small class="text-muted font-weight-bold d-block">ESTIMASI BIAYA KONVERSI LOKAL</small>
                    <div class="display-4 font-weight-bold text-success my-2" id="calcResultDisplay">
                        Rp 15.650.000
                    </div>
                    <small class="text-muted" id="calcRateNote">Kurs Real-Time API: 1 USD = 15,650 IDR</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Exchange Rate Table Card -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-list-alt text-success mr-2"></i> Tabel Kurs Mata Uang Real-Time
        </h4>
        <span class="badge badge-success px-3 py-1 font-weight-bold" id="tableBaseLabel">
            Live Exchange API (USD)
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Kode Mata Uang</th>
                        <th>Nilai Tukar (per 1 <span class="activeBaseCode">USD</span>)</th>
                        <th>Konversi (1,000 <span class="activeBaseCode">USD</span>)</th>
                        <th>Konversi (10,000 <span class="activeBaseCode">USD</span>)</th>
                        <th>Status Volatilitas</th>
                    </tr>
                </thead>

                <tbody id="ratesTableBody">
                    <!-- Dynamic Table Rows Rendered via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let currentRates = @json($rates);
    let currentBase = "{{ $base ?? 'USD' }}";
    let currencyChart = null;

    // Initialize Chart.js
    function initChart() {
        const ctx = document.getElementById('currencyChart').getContext('2d');
        currencyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(currentRates),
                datasets: [{
                    label: `Nilai Tukar per 1 ${currentBase}`,
                    data: Object.values(currentRates),
                    backgroundColor: [
                        '#10b981', '#3b82f6', '#8b5cf6', '#f59e0b', '#06b6d4', 
                        '#ec4899', '#64748b', '#14b8a6', '#f97316', '#a855f7', '#10b981', '#6366f1'
                    ],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    initChart();

    // Fetch Live Exchange Rates from API
    function fetchLiveRates(baseCode) {
        document.getElementById('refreshSpinner').classList.add('fa-spin');

        fetch(`{{ url('/api/currency/live') }}?base=${baseCode}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('refreshSpinner').classList.remove('fa-spin');
                if (res.success && res.rates) {
                    currentBase = res.base;
                    currentRates = res.rates;
                    updateUI();
                }
            })
            .catch(err => {
                document.getElementById('refreshSpinner').classList.remove('fa-spin');
            });
    }

    // Update Entire Dashboard UI
    function updateUI() {
        document.getElementById('chartBaseLabel').innerText = `Base: ${currentBase}`;
        document.getElementById('tableBaseLabel').innerText = `Live Exchange API (${currentBase})`;
        document.getElementById('calcBaseLabel').innerText = currentBase;

        document.querySelectorAll('.activeBaseCode').forEach(el => el.innerText = currentBase);

        renderRateCards();
        renderTable();
        populateCalculatorSelect();
        updateChart();
        updateCalculator();
    }

    // Render Metric Cards
    function renderRateCards() {
        const row = document.getElementById('rateCardsRow');
        const highlighted = ['IDR', 'EUR', 'GBP', 'JPY'];
        let html = '';

        highlighted.forEach(curr => {
            if (ratesDataHas(curr)) {
                const rate = currentRates[curr];
                html += `
                    <div class="col-md-3 mb-3">
                        <div class="card border shadow-sm p-3 h-100" style="border-radius: var(--radius-md);">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge badge-light border text-muted font-weight-bold">1 ${currentBase} =</span>
                                    <h4 class="font-weight-bold text-dark mb-0 mt-1">
                                        ${formatNumber(rate, curr)} <small class="text-success font-weight-bold" style="font-size:0.85rem;">${curr}</small>
                                    </h4>
                                </div>
                                <div class="p-3 rounded-circle bg-light text-success font-weight-bold" style="font-size:1.2rem;">
                                    ${curr}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        row.innerHTML = html;
    }

    function ratesDataHas(curr) {
        return currentRates.hasOwnProperty(curr) && curr !== currentBase;
    }

    // Render Table Rows
    function renderTable() {
        const tbody = document.getElementById('ratesTableBody');
        let index = 1;
        let html = '';

        for (const [currency, rate] of Object.entries(currentRates)) {
            if (currency === currentBase) continue;

            const isVolatile = ['IDR', 'JPY', 'KRW'].includes(currency);
            html += `
                <tr>
                    <td class="text-center text-muted font-weight-bold">${index++}</td>
                    <td>
                        <span class="badge badge-light border font-weight-bold text-dark" style="font-size: 0.9rem;">
                            ${currency}
                        </span>
                    </td>
                    <td>
                        <span class="font-weight-bold text-dark" style="font-size: 1.05rem;">
                            ${formatNumber(rate, currency)}
                        </span>
                    </td>
                    <td>
                        <span class="text-success font-weight-bold">
                            ${(rate * 1000).toLocaleString('en-US', {maximumFractionDigits: 2})} ${currency}
                        </span>
                    </td>
                    <td>
                        <span class="text-primary font-weight-bold">
                            ${(rate * 10000).toLocaleString('en-US', {maximumFractionDigits: 2})} ${currency}
                        </span>
                    </td>
                    <td>
                        <span class="badge ${isVolatile ? 'badge-warning' : 'badge-success'}">
                            ${isVolatile ? 'Moderate Volatility' : 'Stable'}
                        </span>
                    </td>
                </tr>
            `;
        }

        tbody.innerHTML = html;
    }

    // Populate Calculator Target Dropdown
    function populateCalculatorSelect() {
        const select = document.getElementById('calcTargetSelect');
        let html = '';

        for (const [curr, r] of Object.entries(currentRates)) {
            if (curr === currentBase) continue;
            html += `<option value="${r}" data-code="${curr}">${curr} (1 ${currentBase} = ${formatNumber(r, curr)})</option>`;
        }

        select.innerHTML = html;
    }

    // Update Chart.js
    function updateChart() {
        if (!currencyChart) return;
        currencyChart.data.labels = Object.keys(currentRates).filter(c => c !== currentBase);
        currencyChart.data.datasets[0].label = `Nilai Tukar per 1 ${currentBase}`;
        currencyChart.data.datasets[0].data = Object.entries(currentRates)
            .filter(([c]) => c !== currentBase)
            .map(([c, r]) => r > 100 ? (r / 100).toFixed(2) : r.toFixed(2));
        currencyChart.update();
    }

    // Calculator Logic
    const usdInput = document.getElementById('calcUsdInput');
    const targetSelect = document.getElementById('calcTargetSelect');
    const resultDisplay = document.getElementById('calcResultDisplay');
    const rateNote = document.getElementById('calcRateNote');

    function updateCalculator() {
        const amount = parseFloat(usdInput.value) || 0;
        const rate = parseFloat(targetSelect.value) || 1;
        const selectedOption = targetSelect.options[targetSelect.selectedIndex];
        const code = selectedOption ? selectedOption.getAttribute('data-code') : 'IDR';

        const converted = amount * rate;

        if (code === 'IDR') {
            resultDisplay.innerText = 'Rp ' + converted.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        } else {
            resultDisplay.innerText = converted.toLocaleString('en-US', { maximumFractionDigits: 2 }) + ' ' + code;
        }

        rateNote.innerText = `Kurs Real-Time API: 1 ${currentBase} = ${rate.toLocaleString()} ${code}`;
    }

    function formatNumber(num, code) {
        if (code === 'IDR' || code === 'JPY' || code === 'KRW') {
            return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
        return num.toLocaleString('en-US', { minimumFractionDigits: 4, maximumFractionDigits: 4 });
    }

    // Event Listeners
    document.getElementById('baseCurrencySelect').addEventListener('change', function () {
        fetchLiveRates(this.value);
    });

    document.getElementById('btnRefreshExchange').addEventListener('click', function () {
        fetchLiveRates(document.getElementById('baseCurrencySelect').value);
    });

    usdInput.addEventListener('input', updateCalculator);
    targetSelect.addEventListener('change', updateCalculator);

    // Initial Setup
    updateUI();
});
</script>
@stop