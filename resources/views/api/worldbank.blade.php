@extends('adminlte::page')

@section('title', 'World Bank Global Economic Indicators Intelligence')

@section('content_header')
<!-- Integrated Hero Header -->
@stop

@section('css')
<style>
.wb-hero-panel {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 14px 35px -4px rgba(15, 23, 42, 0.25);
    color: #ffffff;
    padding: 1.8rem;
    margin-bottom: 1.75rem;
}

.indicator-pill {
    padding: 10px 18px;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 0.88rem;
    transition: all 0.25s ease;
    border: 1px solid rgba(255, 255, 255, 0.15);
    background: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none !important;
}
.indicator-pill.active {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #ffffff;
    border-color: #818cf8;
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.5);
}
.indicator-pill:hover:not(.active) {
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
}

.wb-card {
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e2e8f0;
}
</style>
@stop

@section('content')

<!-- Enterprise Hero Header -->
<div class="wb-hero-panel">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary pb-3" style="border-color: rgba(255,255,255,0.12) !important;">
        <div>
            <h1 class="font-weight-bold text-white mb-1" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                <i class="fas fa-landmark text-warning mr-2"></i>
                World Bank Macroeconomic Data Intelligence
            </h1>
            <div class="text-light opacity-90" style="font-size: 0.9rem;">
                Official World Bank API Integration (GDP, Inflasi, Populasi, Ekspor & Impor Rantai Pasok)
            </div>
        </div>

        <div>
            <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size:0.83rem; border-radius: var(--radius-pill); background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); color: #34d399;">
                <i class="fas fa-check-circle mr-1"></i> World Bank API v2 Connected
            </span>
        </div>
    </div>

    <!-- Indicator Selection Tabs (PDF Spec Pages 2 & 3) -->
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('worldbank.index', ['indicator' => 'GDP']) }}" class="indicator-pill {{ $indicator === 'GDP' ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> GDP (Produk Domestik Bruto)
        </a>
        <a href="{{ route('worldbank.index', ['indicator' => 'INFLATION']) }}" class="indicator-pill {{ $indicator === 'INFLATION' ? 'active' : '' }}">
            <i class="fas fa-percentage"></i> Inflasi Tahunan
        </a>
        <a href="{{ route('worldbank.index', ['indicator' => 'POPULATION']) }}" class="indicator-pill {{ $indicator === 'POPULATION' ? 'active' : '' }}">
            <i class="fas fa-users"></i> Total Populasi
        </a>
        <a href="{{ route('worldbank.index', ['indicator' => 'EXPORTS']) }}" class="indicator-pill {{ $indicator === 'EXPORTS' ? 'active' : '' }}">
            <i class="fas fa-file-export"></i> Nilai Ekspor Barang & Jasa
        </a>
        <a href="{{ route('worldbank.index', ['indicator' => 'IMPORTS']) }}" class="indicator-pill {{ $indicator === 'IMPORTS' ? 'active' : '' }}">
            <i class="fas fa-file-import"></i> Nilai Impor Barang & Jasa
        </a>
    </div>
</div>

<!-- Indicator Chart Visualization Panel -->
<div class="card wb-card shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas {{ $currentMeta['icon'] }} text-primary mr-2"></i> Visualisasi Data: {{ $currentMeta['label'] }}
        </h4>
        <span class="badge badge-primary font-weight-bold px-3 py-1" style="border-radius: var(--radius-pill);">
            World Bank API Real-Time
        </span>
    </div>
    <div class="card-body p-3">
        <div style="height: 320px; position: relative;">
            <canvas id="worldBankChart"></canvas>
        </div>
    </div>
</div>

<!-- Data Table Card -->
<div class="card wb-card shadow-sm mb-4">
    <div class="card-header bg-white border-bottom py-3">
        <h4 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-list text-primary mr-2"></i> Tabel Data {{ $currentMeta['label'] }}
        </h4>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Negara</th>
                        <th>Kode ISO</th>
                        <th>Tahun Data World Bank</th>
                        <th>Nilai {{ $currentMeta['label'] }}</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($countries as $c)
                    <tr>
                        <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <strong class="text-dark">{{ $c['country']['value'] }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-light border font-weight-bold">{{ $c['countryiso3code'] ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge badge-info px-2 py-1">{{ $c['date'] }}</span>
                        </td>
                        <td>
                            <span class="font-weight-bold text-primary" style="font-size: 1.05rem;">
                                @if($currentMeta['unit'] === '%')
                                    {{ number_format($c['value'], 2) }} %
                                @elseif($currentMeta['unit'] === 'Jiwa')
                                    {{ number_format($c['value']) }} Jiwa
                                @else
                                    $ {{ number_format($c['value']) }} USD
                                @endif
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-exclamation-circle fa-3x mb-3 text-muted opacity-50 d-block"></i>
                            <h6 class="font-weight-bold">Data World Bank sedang diproses</h6>
                        </td>
                    </tr>
                    @endforelse
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
    const rawData = @json($countries);
    const label = "{{ $currentMeta['label'] }}";
    const unit = "{{ $currentMeta['unit'] }}";

    if (!Array.isArray(rawData) || rawData.length === 0) return;

    const countries = rawData.map(item => item.country.value);
    const values = rawData.map(item => item.value);

    const ctx = document.getElementById('worldBankChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: countries,
            datasets: [{
                label: `${label} (${unit})`,
                data: values,
                backgroundColor: 'rgba(99, 102, 241, 0.85)',
                borderColor: '#4f46e5',
                borderWidth: 1,
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
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@stop