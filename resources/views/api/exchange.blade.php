@extends('adminlte::page')

@section('title', 'Perbandingan Kurs Mata Uang Dunia Real-Time')

@section('content_header')
<!-- Integrated Hero Control Panel -->
@stop

@section('css')
<style>
/* Enterprise Exchange Radar Styling */
.exchange-hero-panel {
    background: linear-gradient(135deg, #0f172a 0%, #064e3b 50%, #047857 100%);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 14px 35px -4px rgba(15, 23, 42, 0.25);
    color: #ffffff;
    padding: 1.8rem;
    margin-bottom: 1.75rem;
}

.hero-select-glass {
    background: #ffffff !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: var(--radius-md) !important;
    font-size: 0.95rem !important;
    color: #0f172a !important;
    font-weight: 700 !important;
    padding-right: 2.5rem !important;
    cursor: pointer !important;
}

.currency-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s ease, border-color 0.28s ease;
    overflow: hidden;
}
.currency-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 30px -6px rgba(16, 185, 129, 0.2) !important;
    border-color: #10b981;
}

.currency-flag-avatar {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.calc-display-box {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #bbf7d0;
    border-radius: var(--radius-lg);
    padding: 1.5rem;
    text-align: center;
}

/* Table Hover & Pagination */
.exchange-table tbody tr {
    transition: background-color 0.2s ease;
}
.exchange-table tbody tr:hover {
    background-color: #f8fafc !important;
}

/* Live Pulse Indicator */
.live-dot {
    width: 9px;
    height: 9px;
    background-color: #10b981;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: livePulse 1.6s infinite;
}
@keyframes livePulse {
    0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
    70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
    100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}
</style>
@stop

@section('content')

<!-- Hero Control Panel Header -->
<div class="exchange-hero-panel">
    <!-- Top Header Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary pb-3" style="border-color: rgba(255,255,255,0.15) !important;">
        <div>
            <h1 class="font-weight-bold text-white mb-0" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                <i class="fas fa-globe text-warning mr-2"></i>
                Perbandingan Kurs Mata Uang Seluruh Negara Dunia
            </h1>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span id="liveStatusBadge" class="badge badge-success px-3 py-2 mr-2 shadow-sm d-inline-flex align-items-center" style="font-size:0.83rem; border-radius: var(--radius-pill); background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); color: #34d399;">
                <i class="fas fa-satellite-dish mr-2 fa-spin"></i> Live 160+ Currencies API
            </span>

            <button id="btnRefreshExchange" class="btn btn-warning btn-sm font-weight-bold px-3 py-2 text-dark shadow-sm" style="border-radius: var(--radius-pill); background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none;">
                <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh All Rates
            </button>
        </div>
    </div>

    <!-- Base Currency Selector Row -->
    <div class="row align-items-center">
        <div class="col-md-7 mb-2 mb-md-0">
            <label class="font-weight-bold text-white mb-0" style="font-size:0.95rem;">
                <i class="fas fa-coins text-warning mr-2"></i> Pilih Mata Uang Acuan Utama (Base Currency):
            </label>
        </div>

        <div class="col-md-5">
            <select id="baseCurrencySelect" class="custom-select custom-select-lg hero-select-glass shadow-sm">
                <!-- Options populated dynamically for all world currencies -->
            </select>
        </div>
    </div>
</div>

<!-- Major Foreign Exchange Rate Cards Row (Top 8 Highlighted World Currencies) -->
<div class="row mb-2" id="rateCardsRow">
    <!-- Dynamic Cards Rendered via JS -->
</div>

<!-- Chart.js Currency Trend & Import Calculator Section -->
<div class="row">
    <!-- Chart.js Currency Trend Graph (Value Strength per 1 Unit in USD Equivalent) -->
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: var(--radius-lg);">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h4 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-bar text-success mr-2"></i> Grafik Kekuatan Nilai Tukar Mata Uang (Value vs USD)
                </h4>
                <span class="badge badge-success px-3 py-1 font-weight-bold" id="chartBaseLabel">Base: USD</span>
            </div>
            <div class="card-body p-3">
                <div style="height: 320px; position: relative;">
                    <canvas id="currencyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Live Trade Currency & Import Calculator -->
    <div class="col-lg-5 mb-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: var(--radius-lg);">
            <div class="card-header text-white py-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-top-left-radius: var(--radius-lg); border-top-right-radius: var(--radius-lg);">
                <h4 class="card-title font-weight-bold mb-0">
                    <i class="fas fa-calculator mr-2"></i> Kalkulator Konversi Kurs Semua Negara
                </h4>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-between">
                <div>
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-1"><i class="fas fa-dollar-sign text-success mr-1"></i> Jumlah Anggaran Pengadaan (<span id="calcBaseLabel">USD</span>):</label>
                        <div class="input-group input-group-lg" style="border-radius: var(--radius-md); overflow:hidden;">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white font-weight-bold text-success" id="calcBaseSymbol">$</span>
                            </div>
                            <input type="number" id="calcUsdInput" class="form-control form-control-lg font-weight-bold" value="1000" min="1" step="100">
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-1"><i class="fas fa-coins text-warning mr-1"></i> Pilih Negara / Mata Uang Tujuan Impor:</label>
                        <select id="calcTargetSelect" class="form-control form-control-lg font-weight-bold shadow-sm" style="border-radius: var(--radius-md); background:#ffffff; color:#0f172a; cursor:pointer; height:50px !important; font-size: 0.95rem; border: 1px solid #cbd5e1;">
                            @php
                                $sortedRates = $rates;
                                ksort($sortedRates);
                                $phpMap = [
                                    'IDR' => ['flag' => '🇮🇩', 'name' => 'Rupiah Indonesia', 'country' => 'Indonesia'],
                                    'USD' => ['flag' => '🇺🇸', 'name' => 'Dolar AS', 'country' => 'Amerika Serikat'],
                                    'EUR' => ['flag' => '🇪🇺', 'name' => 'Euro Uni Eropa', 'country' => 'Uni Eropa'],
                                    'GBP' => ['flag' => '🇬🇧', 'name' => 'Pound Sterling', 'country' => 'Inggris / Britania Raya'],
                                    'JPY' => ['flag' => '🇯🇵', 'name' => 'Yen Jepang', 'country' => 'Jepang'],
                                    'SGD' => ['flag' => '🇸🇬', 'name' => 'Dolar Singapura', 'country' => 'Singapura'],
                                    'MYR' => ['flag' => '🇲🇾', 'name' => 'Ringgit Malaysia', 'country' => 'Malaysia'],
                                    'CNY' => ['flag' => '🇨🇳', 'name' => 'Yuan Tiongkok', 'country' => 'Tiongkok (China)'],
                                    'AUD' => ['flag' => '🇦🇺', 'name' => 'Dolar Australia', 'country' => 'Australia'],
                                    'CAD' => ['flag' => '🇨🇦', 'name' => 'Dolar Kanada', 'country' => 'Kanada'],
                                    'KRW' => ['flag' => '🇰🇷', 'name' => 'Won Korea Selatan', 'country' => 'Korea Selatan'],
                                    'THB' => ['flag' => '🇹🇭', 'name' => 'Baht Thailand', 'country' => 'Thailand'],
                                    'SAR' => ['flag' => '🇸🇦', 'name' => 'Riyal Arab Saudi', 'country' => 'Arab Saudi'],
                                    'INR' => ['flag' => '🇮🇳', 'name' => 'Rupee India', 'country' => 'India'],
                                    'BRL' => ['flag' => '🇧🇷', 'name' => 'Real Brasil', 'country' => 'Brasil'],
                                    'RUB' => ['flag' => '🇷🇺', 'name' => 'Ruble Rusia', 'country' => 'Rusia'],
                                    'MXN' => ['flag' => '🇲🇽', 'name' => 'Peso Meksiko', 'country' => 'Meksiko'],
                                    'CHF' => ['flag' => '🇨🇭', 'name' => 'Franc Swiss', 'country' => 'Swiss'],
                                    'ZAR' => ['flag' => '🇿🇦', 'name' => 'Rand Afrika Selatan', 'country' => 'Afrika Selatan'],
                                    'AED' => ['flag' => '🇦🇪', 'name' => 'Dirham UEA', 'country' => 'Uni Emirat Arab'],
                                    'NZD' => ['flag' => '🇳🇿', 'name' => 'Dolar Selandia Baru', 'country' => 'Selandia Baru'],
                                    'TRY' => ['flag' => '🇹🇷', 'name' => 'Lira Turki', 'country' => 'Turki'],
                                    'PHP' => ['flag' => '🇵🇭', 'name' => 'Peso Filipina', 'country' => 'Filipina'],
                                    'VND' => ['flag' => '🇻🇳', 'name' => 'Dong Vietnam', 'country' => 'Vietnam'],
                                    'EGP' => ['flag' => '🇪🇬', 'name' => 'Pound Mesir', 'country' => 'Mesir'],
                                    'PKR' => ['flag' => '🇵🇰', 'name' => 'Rupee Pakistan', 'country' => 'Pakistan'],
                                    'BDT' => ['flag' => '🇧🇩', 'name' => 'Taka Bangladesh', 'country' => 'Bangladesh'],
                                    'HKD' => ['flag' => '🇭🇰', 'name' => 'Dolar Hong Kong', 'country' => 'Hong Kong'],
                                    'TWD' => ['flag' => '🇹🇼', 'name' => 'Dolar Taiwan Baru', 'country' => 'Taiwan'],
                                    'SEK' => ['flag' => '🇸🇪', 'name' => 'Krona Swedia', 'country' => 'Swedia'],
                                    'NOK' => ['flag' => '🇳🇴', 'name' => 'Krone Norwegia', 'country' => 'Norwegia'],
                                    'DKK' => ['flag' => '🇩🇰', 'name' => 'Krone Denmark', 'country' => 'Denmark'],
                                    'PLN' => ['flag' => '🇵🇱', 'name' => 'Zloty Polandia', 'country' => 'Polandia'],
                                    'HUF' => ['flag' => '🇭🇺', 'name' => 'Forint Hongaria', 'country' => 'Hongaria'],
                                    'CZK' => ['flag' => '🇨🇿', 'name' => 'Koruna Ceko', 'country' => 'Republik Ceko'],
                                    'ILS' => ['flag' => '🇮🇱', 'name' => 'Shekel Israel', 'country' => 'Israel'],
                                    'ARS' => ['flag' => '🇦🇷', 'name' => 'Peso Argentina', 'country' => 'Argentina'],
                                    'COP' => ['flag' => '🇨🇴', 'name' => 'Peso Kolombia', 'country' => 'Kolombia'],
                                    'PEN' => ['flag' => '🇵🇪', 'name' => 'Sol Peru', 'country' => 'Peru'],
                                    'CLP' => ['flag' => '🇨🇱', 'name' => 'Peso Cili', 'country' => 'Cili'],
                                    'NGN' => ['flag' => '🇳🇬', 'name' => 'Naira Nigeria', 'country' => 'Nigeria'],
                                    'KWD' => ['flag' => '🇰🇼', 'name' => 'Dinar Kuwait', 'country' => 'Kuwait'],
                                    'BHD' => ['flag' => '🇧🇭', 'name' => 'Dinar Bahrain', 'country' => 'Bahrain'],
                                    'OMR' => ['flag' => '🇴🇲', 'name' => 'Rial Oman', 'country' => 'Oman'],
                                    'QAR' => ['flag' => '🇶🇦', 'name' => 'Riyal Qatar', 'country' => 'Qatar'],
                                    'WST' => ['flag' => '🇼🇸', 'name' => 'Tala Samoa', 'country' => 'Samoa'],
                                    'XAF' => ['flag' => '🇨🇲', 'name' => 'Franc CFA Afrika Tengah', 'country' => 'Kamerun / Afrika Tengah'],
                                    'XCD' => ['flag' => '🇦🇬', 'name' => 'Dolar Karibia Timur', 'country' => 'Karibia Timur'],
                                    'XOF' => ['flag' => '🇸🇳', 'name' => 'Franc CFA Afrika Barat', 'country' => 'Senegal / Afrika Barat'],
                                    'XPF' => ['flag' => '🇵🇫', 'name' => 'Franc CFP', 'country' => 'Polinesia Prancis'],
                                    'YER' => ['flag' => '🇾🇪', 'name' => 'Rial Yaman', 'country' => 'Yaman'],
                                    'ZMW' => ['flag' => '🇿🇲', 'name' => 'Kwacha Zambia', 'country' => 'Zambia'],
                                    'ZWG' => ['flag' => '🇿🇼', 'name' => 'Gold ZiG Zimbabwe', 'country' => 'Zimbabwe'],
                                    'ZWL' => ['flag' => '🇿🇼', 'name' => 'Dolar Zimbabwe', 'country' => 'Zimbabwe'],
                                ];
                            @endphp
                            @foreach($sortedRates as $code => $rate)
                                @if($code !== $base)
                                    @php
                                        $meta = $phpMap[$code] ?? ['flag' => '🌐', 'name' => $code . ' Currency', 'country' => $code];
                                    @endphp
                                    <option value="{{ $rate }}" data-code="{{ $code }}" {{ $code === 'IDR' ? 'selected' : '' }}>
                                        {{ $meta['flag'] }} {{ $code }} — {{ $meta['name'] }} ({{ $meta['country'] }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="calc-display-box mt-3 text-center">
                    <small class="text-success font-weight-bold text-uppercase d-block" style="letter-spacing: 0.05em; font-size:0.75rem;">ESTIMASI BIAYA KONVERSI LOKAL REAL-TIME</small>
                    <div class="display-4 font-weight-bold text-success my-2" id="calcResultDisplay" style="font-size: 2.1rem;">
                        Rp 15.650.000
                    </div>
                    <small class="text-muted font-weight-bold d-block" id="calcRateNote">Kurs Real-Time API: 1 USD = 15,650 IDR</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Exchange Rate Table Card with Real-Time Search Filter for ALL Countries -->
<div class="card shadow-sm border-0 mb-4" style="border-radius: var(--radius-lg);">
    <div class="card-header bg-white border-bottom py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <h4 class="card-title font-weight-bold text-dark mb-1">
                <i class="fas fa-list-alt text-success mr-2"></i> Tabel Kurs Lengkap Mata Uang Seluruh Negara di Dunia
            </h4>
            <div class="text-muted" style="font-size:0.85rem;" id="totalCurrenciesCountLabel">
                Menampilkan 160+ mata uang negara terhubung ke Open Exchange Rates API
            </div>
        </div>

        <!-- Search Input Bar for Table -->
        <div style="min-width: 280px;">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-success"></i></span>
                </div>
                <input type="text" id="currencySearchInput" class="form-control border-left-0" placeholder="Cari nama negara, mata uang (e.g. Rupiah, Yen, Euro, Rupee, AED)...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
            <table class="table exchange-table table-hover mb-0 align-middle">
                <thead class="thead-light" style="position: sticky; top: 0; z-index: 2;">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Mata Uang & Negara</th>
                        <th>Kode ISO</th>
                        <th>Nilai Tukar (per 1 <span class="activeBaseCode">USD</span>)</th>
                        <th>Konversi (1,000 <span class="activeBaseCode">USD</span>)</th>
                        <th>Konversi (10,000 <span class="activeBaseCode">USD</span>)</th>
                        <th>Status Volatilitas</th>
                    </tr>
                </thead>

                <tbody id="ratesTableBody">
                    <!-- Dynamic Table Rows Rendered via JS for all world currencies -->
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

    // Comprehensive Dictionary for ALL 160+ World Currencies & Countries
    const worldCurrencies = {
        'USD': { flag: '🇺🇸', name: 'Dolar Amerika Serikat', country: 'Amerika Serikat', symbol: '$' },
        'IDR': { flag: '🇮🇩', name: 'Rupiah Indonesia', country: 'Indonesia', symbol: 'Rp' },
        'EUR': { flag: '🇪🇺', name: 'Euro Uni Eropa', country: 'Uni Eropa', symbol: '€' },
        'GBP': { flag: '🇬🇧', name: 'Pound Sterling', country: 'Inggris / Britania Raya', symbol: '£' },
        'JPY': { flag: '🇯🇵', name: 'Yen Jepang', country: 'Jepang', symbol: '¥' },
        'SGD': { flag: '🇸🇬', name: 'Dolar Singapura', country: 'Singapura', symbol: 'S$' },
        'MYR': { flag: '🇲🇾', name: 'Ringgit Malaysia', country: 'Malaysia', symbol: 'RM' },
        'CNY': { flag: '🇨🇳', name: 'Yuan / Renminbi China', country: 'Tiongkok (China)', symbol: '¥' },
        'AUD': { flag: '🇦🇺', name: 'Dolar Australia', country: 'Australia', symbol: 'A$' },
        'CAD': { flag: '🇨🇦', name: 'Dolar Kanada', country: 'Kanada', symbol: 'C$' },
        'KRW': { flag: '🇰🇷', name: 'Won Korea Selatan', country: 'Korea Selatan', symbol: '₩' },
        'THB': { flag: '🇹🇭', name: 'Baht Thailand', country: 'Thailand', symbol: '฿' },
        'SAR': { flag: '🇸🇦', name: 'Riyal Arab Saudi', country: 'Arab Saudi', symbol: 'SR' },
        'INR': { flag: '🇮🇳', name: 'Rupee India', country: 'India', symbol: '₹' },
        'BRL': { flag: '🇧🇷', name: 'Real Brasil', country: 'Brasil', symbol: 'R$' },
        'RUB': { flag: '🇷🇺', name: 'Ruble Rusia', country: 'Rusia', symbol: '₽' },
        'MXN': { flag: '🇲🇽', name: 'Peso Meksiko', country: 'Meksiko', symbol: '$' },
        'CHF': { flag: '🇨🇭', name: 'Franc Swiss', country: 'Swiss', symbol: 'CHF' },
        'ZAR': { flag: '🇿🇦', name: 'Rand Afrika Selatan', country: 'Afrika Selatan', symbol: 'R' },
        'AED': { flag: '🇦🇪', name: 'Dirham UEA (Dubai)', country: 'Uni Emirat Arab', symbol: 'AED' },
        'NZD': { flag: '🇳🇿', name: 'Dolar Selandia Baru', country: 'Selandia Baru', symbol: 'NZ$' },
        'TRY': { flag: '🇹🇷', name: 'Lira Turki', country: 'Turki', symbol: '₺' },
        'PHP': { flag: '🇵🇭', name: 'Peso Filipina', country: 'Filipina', symbol: '₱' },
        'VND': { flag: '🇻🇳', name: 'Dong Vietnam', country: 'Vietnam', symbol: '₫' },
        'EGP': { flag: '🇪🇬', name: 'Pound Mesir', country: 'Mesir', symbol: 'E£' },
        'PKR': { flag: '🇵🇰', name: 'Rupee Pakistan', country: 'Pakistan', symbol: '₨' },
        'BDT': { flag: '🇧🇩', name: 'Taka Bangladesh', country: 'Bangladesh', symbol: '৳' },
        'HKD': { flag: '🇭🇰', name: 'Dolar Hong Kong', country: 'Hong Kong', symbol: 'HK$' },
        'TWD': { flag: '🇹🇼', name: 'Dolar Taiwan Baru', country: 'Taiwan', symbol: 'NT$' },
        'SEK': { flag: '🇸🇪', name: 'Krona Swedia', country: 'Swedia', symbol: 'kr' },
        'NOK': { flag: '🇳🇴', name: 'Krone Norwegia', country: 'Norwegia', symbol: 'kr' },
        'DKK': { flag: '🇩🇰', name: 'Krone Denmark', country: 'Denmark', symbol: 'kr' },
        'PLN': { flag: '🇵🇱', name: 'Zloty Polandia', country: 'Polandia', symbol: 'zł' },
        'HUF': { flag: '🇭🇺', name: 'Forint Hongaria', country: 'Hongaria', symbol: 'Ft' },
        'CZK': { flag: '🇨🇿', name: 'Koruna Ceko', country: 'Republik Ceko', symbol: 'Kč' },
        'ILS': { flag: '🇮🇱', name: 'Shekel Baru Israel', country: 'Israel', symbol: '₪' },
        'ARS': { flag: '🇦🇷', name: 'Peso Argentina', country: 'Argentina', symbol: '$' },
        'COP': { flag: '🇨🇴', name: 'Peso Kolombia', country: 'Kolombia', symbol: '$' },
        'PEN': { flag: '🇵🇪', name: 'Sol Peru', country: 'Peru', symbol: 'S/' },
        'CLP': { flag: '🇨🇱', name: 'Peso Cili', country: 'Cili', symbol: '$' },
        'NGN': { flag: '🇳🇬', name: 'Naira Nigeria', country: 'Nigeria', symbol: '₦' },
        'KWD': { flag: '🇰🇼', name: 'Dinar Kuwait', country: 'Kuwait', symbol: 'KD' },
        'BHD': { flag: '🇧🇭', name: 'Dinar Bahrain', country: 'Bahrain', symbol: 'BD' },
        'OMR': { flag: '🇴🇲', name: 'Rial Oman', country: 'Oman', symbol: 'OMR' },
        'QAR': { flag: '🇶🇦', name: 'Riyal Qatar', country: 'Qatar', symbol: 'QR' },
        'AFN': { flag: '🇦🇫', name: 'Afghani Afganistan', country: 'Afganistan', symbol: 'Af' },
        'ALL': { flag: '🇦🇱', name: 'Lek Albania', country: 'Albania', symbol: 'L' },
        'AMD': { flag: '🇦🇲', name: 'Dram Armenia', country: 'Armenia', symbol: '֏' },
        'ANG': { flag: '🇨🇼', name: 'Guilder Antillen Belanda', country: 'Curaçao / Sint Maarten', symbol: 'ƒ' },
        'AOA': { flag: '🇦🇴', name: 'Kwanza Angola', country: 'Angola', symbol: 'Kz' },
        'AWG': { flag: '🇦🇼', name: 'Florin Aruba', country: 'Aruba', symbol: 'Afl' },
        'AZN': { flag: '🇦🇿', name: 'Manat Azerbaijan', country: 'Azerbaijan', symbol: '₼' },
        'BAM': { flag: '🇧🇦', name: 'Mark Konvertibel Bosnia', country: 'Bosnia & Herzegovina', symbol: 'KM' },
        'BBD': { flag: '🇧🇧', name: 'Dolar Barbados', country: 'Barbados', symbol: 'Bds$' },
        'BIF': { flag: '🇧🇮', name: 'Franc Burundi', country: 'Burundi', symbol: 'FBu' },
        'BMD': { flag: '🇧🇲', name: 'Dolar Bermuda', country: 'Bermuda', symbol: '$' },
        'BND': { flag: '🇧🇳', name: 'Dolar Brunei', country: 'Brunei Darussalam', symbol: 'B$' },
        'BOB': { flag: '🇧🇴', name: 'Boliviano Bolivia', country: 'Bolivia', symbol: 'Bs' },
        'BSD': { flag: '🇧🇸', name: 'Dolar Bahama', country: 'Bahama', symbol: 'B$' },
        'BTN': { flag: '🇧🇹', name: 'Ngultrum Bhutan', country: 'Bhutan', symbol: 'Nu' },
        'BWP': { flag: '🇧🇼', name: 'Pula Botswana', country: 'Botswana', symbol: 'P' },
        'BYN': { flag: '🇧🇾', name: 'Ruble Belarusia', country: 'Belarusia', symbol: 'Br' },
        'BZD': { flag: '🇧🇿', name: 'Dolar Belize', country: 'Belize', symbol: 'BZ$' },
        'CDF': { flag: '🇨🇩', name: 'Franc Kongo', country: 'Republik Demokratik Kongo', symbol: 'FC' },
        'CRC': { flag: '🇨🇷', name: 'Colon Kosta Rika', country: 'Kosta Rika', symbol: '₡' },
        'CUP': { flag: '🇨🇺', name: 'Peso Kuba', country: 'Kuba', symbol: '$' },
        'CVE': { flag: '🇨🇻', name: 'Escudo Tanjung Verde', country: 'Tanjung Verde', symbol: 'Esc' },
        'DJF': { flag: '🇩🇯', name: 'Franc Jibuti', country: 'Jibuti', symbol: 'Fdj' },
        'DOP': { flag: '🇩🇴', name: 'Peso Dominika', country: 'Republik Dominika', symbol: 'RD$' },
        'DZD': { flag: '🇩🇿', name: 'Dinar Aljazair', country: 'Aljazair', symbol: 'DA' },
        'ERN': { flag: '🇪🇷', name: 'Nakfa Eritrea', country: 'Eritrea', symbol: 'Nfk' },
        'ETB': { flag: '🇪🇹', name: 'Birr Etiopia', country: 'Etiopia', symbol: 'Br' },
        'FJD': { flag: '🇫🇯', name: 'Dolar Fiji', country: 'Fiji', symbol: 'FJ$' },
        'FKP': { flag: '🇫🇰', name: 'Pound Kepulauan Falkland', country: 'Kepulauan Falkland', symbol: '£' },
        'GEL': { flag: '🇬🇪', name: 'Lari Georgia', country: 'Georgia', symbol: '₾' },
        'GHS': { flag: '🇬🇭', name: 'Cedi Ghana', country: 'Ghana', symbol: 'GH₵' },
        'GIP': { flag: '🇬🇮', name: 'Pound Gibraltar', country: 'Gibraltar', symbol: '£' },
        'GMD': { flag: '🇬🇲', name: 'Dalasi Gambia', country: 'Gambia', symbol: 'D' },
        'GNF': { flag: '🇬🇳', name: 'Franc Guinea', country: 'Guinea', symbol: 'FG' },
        'GTQ': { flag: '🇬🇹', name: 'Quetzal Guatemala', country: 'Guatemala', symbol: 'Q' },
        'GYD': { flag: '🇬🇾', name: 'Dolar Guyana', country: 'Guyana', symbol: 'G$' },
        'HNL': { flag: '🇭🇳', name: 'Lempira Honduras', country: 'Honduras', symbol: 'L' },
        'HTG': { flag: '🇭🇹', name: 'Gourde Haiti', country: 'Haiti', symbol: 'G' },
        'IQD': { flag: '🇮🇶', name: 'Dinar Irak', country: 'Irak', symbol: 'IQD' },
        'IRR': { flag: '🇮🇷', name: 'Rial Iran', country: 'Iran', symbol: '﷼' },
        'ISK': { flag: '🇮🇸', name: 'Krona Islandia', country: 'Islandia', symbol: 'kr' },
        'JMD': { flag: '🇯🇲', name: 'Dolar Jamaika', country: 'Jamaika', symbol: 'J$' },
        'JOD': { flag: '🇯🇴', name: 'Dinar Yordania', country: 'Yordania', symbol: 'JD' },
        'KES': { flag: '🇰🇪', name: 'Shilling Kenya', country: 'Kenya', symbol: 'KSh' },
        'KGS': { flag: '🇰🇬', name: 'Som Kirgizstan', country: 'Kirgizstan', symbol: 'сом' },
        'KHR': { flag: '🇰🇭', name: 'Riel Kamboja', country: 'Kamboja', symbol: '៛' },
        'KMF': { flag: '🇰🇲', name: 'Franc Komoro', country: 'Komoro', symbol: 'CF' },
        'KYD': { flag: '🇰🇾', name: 'Dolar Kepulauan Cayman', country: 'Kepulauan Cayman', symbol: 'CI$' },
        'KZT': { flag: '🇰🇿', name: 'Tenge Kazakhstan', country: 'Kazakhstan', symbol: '₸' },
        'LAK': { flag: '🇱🇦', name: 'Kip Laos', country: 'Laos', symbol: '₭' },
        'LBP': { flag: '🇱🇧', name: 'Pound Lebanon', country: 'Lebanon', symbol: 'L£' },
        'LKR': { flag: '🇱🇰', name: 'Rupee Sri Lanka', country: 'Sri Lanka', symbol: 'Rs' },
        'LRD': { flag: '🇱🇷', name: 'Dolar Liberia', country: 'Liberia', symbol: 'L$' },
        'LSL': { flag: '🇱🇸', name: 'Loti Lesotho', country: 'Lesotho', symbol: 'L' },
        'LYD': { flag: '🇱🇾', name: 'Dinar Libya', country: 'Libya', symbol: 'LD' },
        'MAD': { flag: '🇲🇦', name: 'Dirham Maroko', country: 'Maroko', symbol: 'MAD' },
        'MDL': { flag: '🇲🇩', name: 'Leu Moldova', country: 'Moldova', symbol: 'L' },
        'MGA': { flag: '🇲🇬', name: 'Ariary Madagaskar', country: 'Madagaskar', symbol: 'Ar' },
        'MKD': { flag: '🇲🇰', name: 'Denar Makedonia Utara', country: 'Makedonia Utara', symbol: 'den' },
        'MMK': { flag: '🇲🇲', name: 'Kyat Myanmar', country: 'Myanmar', symbol: 'Ks' },
        'MNT': { flag: '🇲🇳', name: 'Tugrik Mongolia', country: 'Mongolia', symbol: '₮' },
        'MOP': { flag: '🇲🇴', name: 'Pataca Makau', country: 'Makau', symbol: 'MOP$' },
        'MRU': { flag: '🇲🇷', name: 'Ouguiya Mauritania', country: 'Mauritania', symbol: 'UM' },
        'MUR': { flag: '🇲🇺', name: 'Rupee Mauritius', country: 'Mauritius', symbol: '₨' },
        'MVR': { flag: '🇲🇻', name: 'Rufiyaa Maladewa', country: 'Maladewa', symbol: 'Rf' },
        'MWK': { flag: '🇲🇼', name: 'Kwacha Malawi', country: 'Malawi', symbol: 'MK' },
        'MZN': { flag: '🇲🇿', name: 'Metical Mozambik', country: 'Mozambik', symbol: 'MT' },
        'NAD': { flag: '🇳🇦', name: 'Dolar Namibia', country: 'Namibia', symbol: 'N$' },
        'NIO': { flag: '🇳🇮', name: 'Cordoba Nikaragua', country: 'Nikaragua', symbol: 'C$' },
        'NPR': { flag: '🇳🇵', name: 'Rupee Nepal', country: 'Nepal', symbol: 'Rs' },
        'PAB': { flag: '🇵🇦', name: 'Balboa Panama', country: 'Panama', symbol: 'B/.' },
        'PGK': { flag: '🇵🇬', name: 'Kina Papua Nugini', country: 'Papua Nugini', symbol: 'K' },
        'PYG': { flag: '🇵🇾', name: 'Guarani Paraguay', country: 'Paraguay', symbol: '₲' },
        'RON': { flag: '🇷🇴', name: 'Leu Rumania', country: 'Rumania', symbol: 'lei' },
        'RSD': { flag: '🇷🇸', name: 'Dinar Serbia', country: 'Serbia', symbol: 'din.' },
        'RWF': { flag: '🇷🇼', name: 'Franc Rwanda', country: 'Rwanda', symbol: 'RF' },
        'SBD': { flag: '🇸🇧', name: 'Dolar Kepulauan Solomon', country: 'Kepulauan Solomon', symbol: 'SI$' },
        'SCR': { flag: '🇸🇨', name: 'Rupee Seychelles', country: 'Seychelles', symbol: 'SR' },
        'SDG': { flag: '🇸🇩', name: 'Pound Sudan', country: 'Sudan', symbol: 'SDG' },
        'SHP': { flag: '🇸🇭', name: 'Pound Saint Helena', country: 'Saint Helena', symbol: '£' },
        'SLE': { flag: '🇸🇱', name: 'Leone Sierra Leone', country: 'Sierra Leone', symbol: 'Le' },
        'SLL': { flag: '🇸🇱', name: 'Leone Sierra Leone (Lama)', country: 'Sierra Leone', symbol: 'Le' },
        'SOS': { flag: '🇸🇴', name: 'Shilling Somalia', country: 'Somalia', symbol: 'Ssh' },
        'SRD': { flag: '🇸🇷', name: 'Dolar Suriname', country: 'Suriname', symbol: 'Sr$' },
        'SSP': { flag: '🇸🇸', name: 'Pound Sudan Selatan', country: 'Sudan Selatan', symbol: 'SS£' },
        'STN': { flag: '🇸🇹', name: 'Dobra Sao Tome', country: 'Sao Tome & Principe', symbol: 'Db' },
        'SVC': { flag: '🇸🇻', name: 'Colon El Salvador', country: 'El Salvador', symbol: '$' },
        'SYP': { flag: '🇸🇾', name: 'Pound Suriah', country: 'Suriah', symbol: 'LS' },
        'SZL': { flag: '🇸🇿', name: 'Lilangeni Eswatini', country: 'Eswatini', symbol: 'L' },
        'TJS': { flag: '🇹🇯', name: 'Somoni Tajikistan', country: 'Tajikistan', symbol: 'SM' },
        'TMT': { flag: '🇹🇲', name: 'Manat Turkmenistan', country: 'Turkmenistan', symbol: 'T' },
        'TND': { flag: '🇹🇳', name: 'Dinar Tunisia', country: 'Tunisia', symbol: 'DT' },
        'TOP': { flag: '🇹🇴', name: 'Paanga Tonga', country: 'Tonga', symbol: 'T$' },
        'TTD': { flag: '🇹🇹', name: 'Dolar Trinidad & Tobago', country: 'Trinidad & Tobago', symbol: 'TT$' },
        'TZS': { flag: '🇹🇿', name: 'Shilling Tanzania', country: 'Tanzania', symbol: 'TSh' },
        'UAH': { flag: '🇺🇦', name: 'Hryvnia Ukraina', country: 'Ukraina', symbol: '₴' },
        'UGX': { flag: '🇺🇬', name: 'Shilling Uganda', country: 'Uganda', symbol: 'USh' },
        'UYU': { flag: '🇺🇾', name: 'Peso Uruguay', country: 'Uruguay', symbol: '$U' },
        'UZS': { flag: '🇺🇿', name: 'Som Uzbekistan', country: 'Uzbekistan', symbol: 'soʻm' },
        'VUV': { flag: '🇻🇺', name: 'Vatu Vanuatu', country: 'Vanuatu', symbol: 'VT' },
        'WST': { flag: '🇼🇸', name: 'Tala Samoa', country: 'Samoa', symbol: 'WS$' },
        'XAF': { flag: '🇨🇲', name: 'Franc CFA Afrika Tengah', country: 'Kamerun / Afrika Tengah', symbol: 'FCFA' },
        'XCD': { flag: '🇦🇬', name: 'Dolar Karibia Timur', country: 'Karibia Timur', symbol: 'EC$' },
        'XCG': { flag: '🇨🇼', name: 'Guilder Karibia', country: 'Karibia', symbol: 'Cg' },
        'XDR': { flag: '🌐', name: 'Hak Penarikan Khusus IMF', country: 'IMF (Dana Moneter Internasional)', symbol: 'SDR' },
        'XOF': { flag: '🇸🇳', name: 'Franc CFA Afrika Barat', country: 'Senegal / Afrika Barat', symbol: 'CFA' },
        'XPF': { flag: '🇵🇫', name: 'Franc CFP', country: 'Polinesia Prancis', symbol: 'CFP' },
        'YER': { flag: '🇾🇪', name: 'Rial Yaman', country: 'Yaman', symbol: '﷼' },
        'ZMW': { flag: '🇿🇲', name: 'Kwacha Zambia', country: 'Zambia', symbol: 'ZK' },
        'ZWG': { flag: '🇿🇼', name: 'Gold ZiG Zimbabwe', country: 'Zimbabwe', symbol: 'ZiG' },
        'ZWL': { flag: '🇿🇼', name: 'Dolar Zimbabwe', country: 'Zimbabwe', symbol: 'Z$' }
    };

    // Helper to get currency metadata for any currency code
    function getMeta(code) {
        if (worldCurrencies[code]) return worldCurrencies[code];
        return {
            flag: '🌐',
            name: `${code} Currency`,
            country: code,
            symbol: code
        };
    }

    // Populate Base Currency Selector for ALL Currencies
    function populateBaseCurrencyOptions() {
        const select = document.getElementById('baseCurrencySelect');
        let html = '';

        const priorityCodes = ['USD', 'EUR', 'GBP', 'IDR', 'JPY', 'SGD', 'CNY', 'AUD', 'CAD', 'KRW', 'MYR', 'SAR', 'INR', 'AED'];
        const allCodes = Object.keys(currentRates).sort();

        priorityCodes.forEach(code => {
            if (currentRates.hasOwnProperty(code)) {
                const meta = getMeta(code);
                const selected = code === currentBase ? 'selected' : '';
                html += `<option value="${code}" ${selected}>${meta.flag} ${code} — ${meta.name} (${meta.country})</option>`;
            }
        });

        html += `<option disabled>----------------------------------------</option>`;

        allCodes.forEach(code => {
            if (!priorityCodes.includes(code)) {
                const meta = getMeta(code);
                const selected = code === currentBase ? 'selected' : '';
                html += `<option value="${code}" ${selected}>${meta.flag} ${code} — ${meta.name} (${meta.country})</option>`;
            }
        });

        select.innerHTML = html;
    }

    // Initialize Chart.js Bar Chart (Strength Value per 1 Unit in USD Equivalent: 1 / rate)
    function initChart() {
        const ctx = document.getElementById('currencyChart').getContext('2d');
        const keys = ['GBP', 'EUR', 'SGD', 'AUD', 'CAD', 'SAR', 'MYR', 'CNY', 'INR', 'JPY', 'IDR'].filter(c => c !== currentBase);

        // Value Strength (USD per 1 Unit of Currency = 1 / Rate)
        const values = keys.map(c => {
            const r = currentRates[c] || 1;
            const usdValue = 1 / r;
            if (usdValue >= 0.01) {
                return usdValue.toFixed(4);
            }
            return (usdValue * 1000).toFixed(4); // Scaled for JPY/IDR readability
        });

        currencyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: keys.map(c => getMeta(c).flag + ' ' + c),
                datasets: [{
                    label: `Kekuatan Value per 1 Unit (${currentBase} Equiv)`,
                    data: values,
                    backgroundColor: [
                        '#8b5cf6', '#3b82f6', '#06b6d4', '#10b981', '#14b8a6', 
                        '#64748b', '#f59e0b', '#f97316', '#a855f7', '#ec4899', '#ef4444'
                    ],
                    borderRadius: 6,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                const curr = keys[ctx.dataIndex];
                                const orig = currentRates[curr] || 1;
                                const valInUsd = (1 / orig).toFixed(6);
                                return ` 1 ${curr} = $${valInUsd} USD (Nominal: 1 USD = ${formatNumber(orig, curr)} ${curr})`;
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    initChart();

    // Fetch Live Exchange Rates from API for ALL world currencies
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
        document.getElementById('tableBaseLabel').innerText = `Live API (${currentBase})`;
        document.getElementById('calcBaseLabel').innerText = currentBase;

        const baseMeta = getMeta(currentBase);
        document.getElementById('calcBaseSymbol').innerText = baseMeta.symbol;

        document.querySelectorAll('.activeBaseCode').forEach(el => el.innerText = currentBase);

        const totalCount = Object.keys(currentRates).length;
        document.getElementById('totalCurrenciesCountLabel').innerText = `Terhubung ke Open Exchange Rates API Real-Time: Menampilkan ${totalCount} mata uang negara di dunia`;

        populateBaseCurrencyOptions();
        renderRateCards();
        renderTable();
        populateCalculatorSelect();
        updateChart();
        updateCalculator();
    }

    // Render Metric Cards (Top Highlighted World Currencies)
    function renderRateCards() {
        const row = document.getElementById('rateCardsRow');
        const highlighted = ['IDR', 'EUR', 'GBP', 'JPY', 'CNY', 'SGD', 'AUD', 'CAD', 'INR', 'KRW', 'SAR', 'MYR'].filter(c => c !== currentBase).slice(0, 4);
        let html = '';

        highlighted.forEach(curr => {
            if (currentRates.hasOwnProperty(curr)) {
                const rate = currentRates[curr];
                const meta = getMeta(curr);
                const isVolatile = ['IDR', 'JPY', 'KRW', 'ARS', 'TRY', 'VND'].includes(curr);

                html += `
                    <div class="col-md-3 col-6 mb-3">
                        <div class="card currency-card shadow-sm p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge badge-light border text-muted font-weight-bold" style="font-size:0.75rem;">1 ${currentBase} =</span>
                                <span class="badge ${isVolatile ? 'badge-warning' : 'badge-success'} font-weight-bold" style="font-size:0.72rem;">
                                    ${isVolatile ? 'Volatile' : 'Stable'}
                                </span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="font-weight-bold text-dark mb-0" style="font-size:1.35rem;">
                                        ${formatNumber(rate, curr)}
                                    </h3>
                                    <small class="font-weight-bold text-success">${meta.flag} ${curr} (${meta.country})</small>
                                </div>
                                <div class="currency-flag-avatar">
                                    ${meta.flag}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        });

        row.innerHTML = html;
    }

    // Render Detailed Table Rows for ALL World Currencies
    function renderTable() {
        const tbody = document.getElementById('ratesTableBody');
        const searchVal = (document.getElementById('currencySearchInput').value || '').toLowerCase().trim();

        let index = 1;
        let html = '';

        const sortedEntries = Object.entries(currentRates).sort((a, b) => a[0].localeCompare(b[0]));

        for (const [currency, rate] of sortedEntries) {
            if (currency === currentBase) continue;

            const meta = getMeta(currency);
            const matchSearch = !searchVal || 
                currency.toLowerCase().includes(searchVal) ||
                meta.name.toLowerCase().includes(searchVal) ||
                meta.country.toLowerCase().includes(searchVal);

            if (!matchSearch) continue;

            const isVolatile = ['IDR', 'JPY', 'KRW', 'ARS', 'TRY', 'VND', 'RUB', 'NGN'].includes(currency);

            html += `
                <tr>
                    <td class="text-center text-muted font-weight-bold">${index++}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <span class="mr-2" style="font-size:1.5rem;">${meta.flag}</span>
                            <div>
                                <strong class="text-dark d-block">${meta.name}</strong>
                                <small class="text-muted"><i class="fas fa-globe-americas mr-1"></i> ${meta.country}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-light border font-weight-bold text-dark" style="font-size: 0.88rem;">
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
                        <span class="badge ${isVolatile ? 'badge-warning' : 'badge-success'} font-weight-bold px-3 py-1" style="border-radius: var(--radius-pill);">
                            ${isVolatile ? 'Moderate Volatility' : 'Stable Rate'}
                        </span>
                    </td>
                </tr>
            `;
        }

        if (html === '') {
            html = `<tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-coins fa-2x mb-2 opacity-50 d-block"></i>Tidak ada mata uang yang cocok dengan kata kunci "${searchVal}"</td></tr>`;
        }

        tbody.innerHTML = html;
    }

    // Populate Calculator Target Dropdown for ALL Currencies (Scrollable List Box)
    function populateCalculatorSelect() {
        const select = document.getElementById('calcTargetSelect');
        if (!select) return;

        let html = '';
        let idrIndex = 0;
        let count = 0;

        const sortedEntries = Object.entries(currentRates).sort((a, b) => a[0].localeCompare(b[0]));

        for (const [curr, r] of sortedEntries) {
            if (curr === currentBase) continue;
            const meta = getMeta(curr);
            const isSelected = curr === 'IDR' ? 'selected' : '';

            if (curr === 'IDR') {
                idrIndex = count;
            }

            html += `<option value="${r}" data-code="${curr}" ${isSelected} style="padding: 6px 10px; font-size: 0.9rem;">${meta.flag} ${curr} — ${meta.name} (${meta.country})</option>`;
            count++;
        }

        select.innerHTML = html;
        if (select.options.length > idrIndex) {
            select.selectedIndex = idrIndex;
        }
        updateCalculator();
    }

    // Update Chart.js Data (Strength Value per 1 Unit in USD Equivalent: 1 / rate)
    function updateChart() {
        if (!currencyChart) return;
        const keys = ['GBP', 'EUR', 'SGD', 'AUD', 'CAD', 'SAR', 'MYR', 'CNY', 'INR', 'JPY', 'IDR'].filter(c => c !== currentBase);

        const values = keys.map(c => {
            const r = currentRates[c] || 1;
            const usdValue = 1 / r;
            if (usdValue >= 0.01) {
                return usdValue.toFixed(4);
            }
            return (usdValue * 1000).toFixed(4);
        });

        currencyChart.data.labels = keys.map(c => getMeta(c).flag + ' ' + c);
        currencyChart.data.datasets[0].label = `Kekuatan Value per 1 Unit (${currentBase} Equiv)`;
        currencyChart.data.datasets[0].data = values;
        currencyChart.update();
    }

    // Calculator Logic
    const usdInput = document.getElementById('calcUsdInput');
    const targetSelect = document.getElementById('calcTargetSelect');
    const targetSearchInput = document.getElementById('calcTargetSearchInput');
    const resultDisplay = document.getElementById('calcResultDisplay');
    const rateNote = document.getElementById('calcRateNote');

    function updateCalculator() {
        if (!targetSelect || !usdInput) return;

        const amount = parseFloat(usdInput.value) || 0;
        const selectedOption = targetSelect.options[targetSelect.selectedIndex];

        if (!selectedOption || selectedOption.disabled) {
            resultDisplay.innerText = '-';
            rateNote.innerText = 'Silakan pilih mata uang yang valid';
            return;
        }

        const rate = parseFloat(targetSelect.value) || 1;
        const code = selectedOption.getAttribute('data-code') || 'IDR';

        const converted = amount * rate;
        const meta = getMeta(code);

        if (code === 'IDR') {
            resultDisplay.innerText = 'Rp ' + converted.toLocaleString('id-ID', { maximumFractionDigits: 0 });
        } else {
            resultDisplay.innerText = `${meta.symbol} ` + converted.toLocaleString('en-US', { maximumFractionDigits: 2 }) + ` ${code}`;
        }

        rateNote.innerText = `Kurs Real-Time API: 1 ${currentBase} = ${formatNumber(rate, code)} ${code} (${meta.name})`;
    }

    function formatNumber(num, code) {
        if (code === 'IDR' || code === 'JPY' || code === 'KRW' || code === 'VND') {
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

    document.getElementById('currencySearchInput').addEventListener('keyup', renderTable);

    if (usdInput) usdInput.addEventListener('input', updateCalculator);
    if (targetSelect) targetSelect.addEventListener('change', updateCalculator);

    if (targetSearchInput) {
        targetSearchInput.addEventListener('keyup', function() {
            populateCalculatorSelect(this.value);
        });
    }

    // Initial Setup
    updateUI();
});
</script>
@stop