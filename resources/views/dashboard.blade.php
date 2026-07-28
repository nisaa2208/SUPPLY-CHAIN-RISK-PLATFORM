@extends('adminlte::page')

@section('title', 'Global Dashboard — Supply Chain Risk Intelligence')

@section('content_header')
<!-- Integrated Header -->
@stop

@section('css')
<style>
/* Modern Responsive Dashboard Layout */
.gsc-header {
    margin-bottom: 1.5rem;
}

.gsc-title {
    font-size: 1.65rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 0.2rem;
}

.gsc-subtitle {
    font-size: 0.88rem;
    color: #64748b;
}

.gsc-search-input {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: var(--radius-pill);
    padding: 0.45rem 1rem 0.45rem 2.2rem;
    font-size: 0.85rem;
    width: 230px;
    transition: all 0.2s ease;
}
.gsc-search-input:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}

/* Stat Cards Row */
.gsc-stat-card {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
    padding: 1.1rem;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    height: 100%;
}
.gsc-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
}

.gsc-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.gsc-stat-val {
    font-size: 1.55rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
}

.gsc-stat-lbl {
    font-size: 0.76rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

/* Panel Cards */
.gsc-panel {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    margin-bottom: 1.25rem;
    overflow: hidden;
}

.gsc-panel-header {
    padding: 0.85rem 1.1rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.gsc-panel-title {
    font-size: 0.9rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0;
    white-space: nowrap;
}

.gsc-view-all {
    font-size: 0.78rem;
    font-weight: 700;
    color: #3b82f6;
    text-decoration: none !important;
}

/* Floating Map Legend */
.gsc-map-legend {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(255, 255, 255, 0.94);
    backdrop-filter: blur(6px);
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 0.72rem;
    font-weight: 600;
    z-index: 999;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.gsc-legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 3px;
}
.gsc-legend-item:last-child {
    margin-bottom: 0;
}

.gsc-legend-box {
    width: 10px;
    height: 10px;
    border-radius: 2px;
}

/* Rank Items */
.gsc-rank-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem 1.1rem;
    border-bottom: 1px solid #f1f5f9;
}
.gsc-rank-item:last-child {
    border-bottom: none;
}

/* News List Item */
.gsc-news-item {
    display: flex;
    gap: 12px;
    padding: 0.75rem 1.1rem;
    border-bottom: 1px solid #f1f5f9;
    align-items: center;
}
.gsc-news-item:last-child {
    border-bottom: none;
}

.gsc-news-thumb {
    width: 54px;
    height: 48px;
    border-radius: 8px;
    object-fit: cover;
    flex-shrink: 0;
}

.gsc-news-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.3;
    margin-bottom: 2px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Mini Stat Card Clean Typography */
.gsc-mini-stat {
    background: #ffffff;
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
    padding: 1.1rem;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    height: 100%;
}
.gsc-mini-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #475569;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.gsc-mini-val {
    font-size: 1.55rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
    margin-top: 0.2rem;
    margin-bottom: 0.4rem;
}

/* Table Clean Styling */
.gsc-table {
    table-layout: fixed;
    width: 100%;
}
.gsc-table th {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #64748b;
    font-weight: 800;
    border-bottom: 1px solid #e2e8f0 !important;
    padding: 0.6rem 0.75rem !important;
}
.gsc-table td {
    font-size: 0.82rem;
    font-weight: 600;
    vertical-align: middle !important;
    padding: 0.6rem 0.75rem !important;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Bell Notification Clean Badge */
.gsc-bell-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #334155;
    transition: all 0.2s ease;
}
.gsc-bell-btn:hover {
    background: #f8fafc;
    color: #2563eb;
}
.gsc-bell-badge {
    position: absolute;
    top: -3px;
    right: -3px;
    background-color: #ef4444;
    color: #ffffff;
    font-size: 0.65rem;
    font-weight: 800;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
}
</style>
@stop

@section('content')

<!-- Top Header Navigation & Action Bar -->
<div class="gsc-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h1 class="gsc-title mb-0">Global Dashboard</h1>
    </div>

    <div class="d-flex align-items-center flex-wrap gap-2">
        <!-- Search Input -->
        <div class="position-relative d-none d-md-block mr-2">
            <i class="fas fa-search position-absolute text-muted" style="left: 12px; top: 11px; font-size: 0.8rem;"></i>
            <input type="text" id="globalSearchInput" class="gsc-search-input" placeholder="Search country, port, news...">
        </div>

        <!-- Notification Bell Widget -->
        <div class="position-relative mr-2" title="Notifikasi Peringatan Risiko Sistem">
            <button class="btn gsc-bell-btn shadow-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-bell"></i>
            </button>
            <span class="gsc-bell-badge">1</span>

            <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 p-2" style="width: 280px; border-radius: var(--radius-md);">
                <div class="font-weight-bold text-dark px-2 py-1 border-bottom d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-bell text-primary mr-1"></i> Peringatan Risiko Live</span>
                    <span class="badge badge-danger">1 Baru</span>
                </div>
                <div class="p-2 border-bottom" style="font-size:0.8rem;">
                    <strong class="text-danger d-block"><i class="fas fa-exclamation-triangle mr-1"></i> High Risk Warning</strong>
                    <span class="text-muted">Risiko pengiriman maritim Laut Red Sea terdeteksi mengalami penundaan.</span>
                </div>
                <a href="{{ route('news.index') }}" class="dropdown-item text-center font-weight-bold text-primary py-2" style="font-size:0.8rem;">
                    Lihat Semua Berita Risiko <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- User Avatar Profile -->
        <div class="d-flex align-items-center mr-2 bg-white px-3 py-1 rounded-pill border shadow-sm">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=6366f1&color=fff" class="rounded-circle mr-2" style="width:26px; height:26px;" alt="User">
            <span class="font-weight-bold text-dark" style="font-size:0.83rem;">{{ auth()->user()->role ?? 'Admin' }}</span>
        </div>

        <!-- Date Picker Badge -->
        <div class="badge badge-light border px-3 py-2 text-dark font-weight-bold shadow-sm d-none d-lg-flex align-items-center mr-2" style="font-size:0.82rem; border-radius: 8px;">
            <i class="far fa-calendar-alt mr-2 text-primary"></i> {{ date('d M Y') }}
        </div>

        <!-- Refresh Data Button -->
        <a href="{{ route('dashboard') }}" class="btn btn-primary font-weight-bold shadow-sm px-3 py-2" style="background: #2563eb; border: none; border-radius: var(--radius-md); font-size:0.85rem;">
            <i class="fas fa-sync-alt mr-1"></i> Refresh Data
        </a>
    </div>
</div>

<!-- Top 5 Metrics Cards Row -->
<div class="row mb-4">
    <!-- Total Countries -->
    <div class="col-xl col-lg-4 col-md-4 col-6 mb-3 mb-xl-0">
        <div class="gsc-stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="gsc-stat-lbl">Total Countries</span>
                <div class="gsc-stat-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fas fa-globe"></i>
                </div>
            </div>
            <div class="gsc-stat-val">{{ $totalCountriesCount }}</div>
            <div class="text-muted font-weight-bold" style="font-size:0.75rem;">Monitored</div>
            <div class="text-success font-weight-bold mt-1" style="font-size:0.75rem;"><i class="fas fa-arrow-up mr-1"></i> 3 this week</div>
        </div>
    </div>

    <!-- High Risk Countries -->
    <div class="col-xl col-lg-4 col-md-4 col-6 mb-3 mb-xl-0">
        <div class="gsc-stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="gsc-stat-lbl">High Risk Countries</span>
                <div class="gsc-stat-icon" style="background: #fef2f2; color: #ef4444;">
                    <i class="fas fa-shield-alt"></i>
                </div>
            </div>
            <div class="gsc-stat-val">{{ $highRisk }}</div>
            <div class="text-muted font-weight-bold" style="font-size:0.75rem;">Countries</div>
            <div class="text-danger font-weight-bold mt-1" style="font-size:0.75rem;"><i class="fas fa-arrow-up mr-1"></i> 2 this week</div>
        </div>
    </div>

    <!-- Medium Risk Countries -->
    <div class="col-xl col-lg-4 col-md-4 col-6 mb-3 mb-xl-0">
        <div class="gsc-stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="gsc-stat-lbl">Medium Risk Countries</span>
                <div class="gsc-stat-icon" style="background: #fffbeb; color: #f59e0b;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="gsc-stat-val">{{ $mediumRisk }}</div>
            <div class="text-muted font-weight-bold" style="font-size:0.75rem;">Countries</div>
            <div class="text-warning font-weight-bold mt-1" style="font-size:0.75rem;"><i class="fas fa-arrow-up mr-1"></i> 5 this week</div>
        </div>
    </div>

    <!-- Low Risk Countries -->
    <div class="col-xl col-lg-4 col-md-4 col-6 mb-3 mb-xl-0">
        <div class="gsc-stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="gsc-stat-lbl">Low Risk Countries</span>
                <div class="gsc-stat-icon" style="background: #f0fdf4; color: #10b981;">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="gsc-stat-val">{{ $lowRisk }}</div>
            <div class="text-muted font-weight-bold" style="font-size:0.75rem;">Countries</div>
            <div class="text-success font-weight-bold mt-1" style="font-size:0.75rem;"><i class="fas fa-arrow-up mr-1"></i> 4 this week</div>
        </div>
    </div>

    <!-- Avg Risk Score -->
    <div class="col-xl col-lg-4 col-md-4 col-12">
        <div class="gsc-stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="gsc-stat-lbl">Avg. Risk Score</span>
                <div class="gsc-stat-icon" style="background: #faf5ff; color: #a855f7;">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
            <div class="gsc-stat-val">{{ $avgRiskScore }} <small class="text-muted font-weight-bold" style="font-size:0.85rem;">Medium</small></div>
            <div class="text-primary font-weight-bold mt-2" style="font-size:0.75rem;"><i class="fas fa-arrow-down mr-1"></i> 2.1 vs last week</div>
        </div>
    </div>
</div>

<!-- Middle Section Row 1 (Map 5-cols, Top Risk 3-cols, Latest News 4-cols = 12 Grid) -->
<div class="row">
    <!-- Left Column: Global Risk Map (Col-lg-5) -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="gsc-panel h-100 position-relative">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Global Risk Map</h5>
            </div>
            <div class="p-0 position-relative" style="height: 350px;">
                <div id="worldMap" style="height: 100%; width: 100%;"></div>

                <!-- Floating Map Legend -->
                <div class="gsc-map-legend">
                    <div class="gsc-legend-item">
                        <div class="gsc-legend-box" style="background: #ef4444;"></div>
                        <span>High Risk</span>
                    </div>
                    <div class="gsc-legend-item">
                        <div class="gsc-legend-box" style="background: #f59e0b;"></div>
                        <span>Medium Risk</span>
                    </div>
                    <div class="gsc-legend-item">
                        <div class="gsc-legend-box" style="background: #10b981;"></div>
                        <span>Low Risk</span>
                    </div>
                    <div class="gsc-legend-item">
                        <div class="gsc-legend-box" style="background: #cbd5e1;"></div>
                        <span>No Data</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Middle Column: Top 5 Countries by Risk Score (Col-lg-3) -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Top 5 Countries by Risk Score</h5>
                <a href="{{ route('countries.index') }}" class="gsc-view-all">View all</a>
            </div>
            <div class="p-0">
                @forelse($topRiskCountries as $idx => $c)
                    @php
                        $isHigh = $c->risk_score >= 60;
                        $badgeColor = $isHigh ? 'background:#fef2f2; color:#ef4444;' : 'background:#fffbeb; color:#f59e0b;';
                        $flagUrl = "https://flagcdn.com/w40/" . strtolower($c->code) . ".png";
                    @endphp
                    <div class="gsc-rank-item">
                        <div class="d-flex align-items-center" style="min-width: 0;">
                            <span class="font-weight-bold text-muted mr-2" style="width:14px; font-size:0.8rem; flex-shrink: 0;">{{ $idx + 1 }}</span>
                            <img src="{{ $flagUrl }}" class="rounded mr-2" style="width:20px; height:14px; object-fit:cover; flex-shrink: 0;" onerror="this.style.display='none'">
                            <span class="font-weight-bold text-dark text-truncate" style="font-size:0.82rem;">{{ $c->name }}</span>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0">
                            <span class="font-weight-bold text-dark mr-2" style="font-size:0.82rem;">{{ $c->risk_score }}</span>
                            <span class="badge font-weight-bold px-2 py-1" style="font-size:0.68rem; border-radius: 4px; {{ $badgeColor }}">
                                {{ $isHigh ? 'High' : 'Medium' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-muted">No high risk countries</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Column: Latest News (Col-lg-4) -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Latest News</h5>
                <a href="{{ route('news.index') }}" class="gsc-view-all">View all</a>
            </div>
            <div class="p-0">
                @foreach($latestNews as $news)
                    <div class="gsc-news-item">
                        <img src="{{ $news['image'] }}" class="gsc-news-thumb" alt="News">
                        <div>
                            <a href="{{ $news['url'] }}" class="gsc-news-title text-dark hover:text-primary">{{ $news['title'] }}</a>
                            <div class="text-muted" style="font-size:0.72rem;">
                                <span class="font-weight-bold text-secondary">{{ $news['category'] }}</span> &bull; {{ $news['time'] }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Middle Section Row 2 (4 Financial/Economic Mini Stat Cards) -->
<div class="row mb-4">
    <!-- Global GDP -->
    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
        <div class="gsc-mini-stat">
            <div class="d-flex justify-content-between align-items-center">
                <span class="gsc-mini-title"><i class="fas fa-globe text-success mr-1"></i> Global GDP</span>
                <span class="text-success font-weight-bold" style="font-size: 0.72rem; white-space: nowrap;"><i class="fas fa-arrow-up mr-1"></i> 1.8% vs last month</span>
            </div>
            <div class="gsc-mini-val">$105.3T</div>
            <svg height="20" width="100%" viewBox="0 0 100 25" preserveAspectRatio="none">
                <path d="M0,20 Q25,5 50,15 T100,5" fill="none" stroke="#10b981" stroke-width="2"/>
            </svg>
        </div>
    </div>

    <!-- Global Inflation -->
    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
        <div class="gsc-mini-stat">
            <div class="d-flex justify-content-between align-items-center">
                <span class="gsc-mini-title"><i class="fas fa-chart-line text-purple mr-1"></i> Global Inflation</span>
                <span class="text-purple font-weight-bold" style="font-size: 0.72rem; color:#a855f7; white-space: nowrap;"><i class="fas fa-arrow-up mr-1"></i> 0.3% vs last month</span>
            </div>
            <div class="gsc-mini-val">4.2%</div>
            <svg height="20" width="100%" viewBox="0 0 100 25" preserveAspectRatio="none">
                <path d="M0,15 Q25,22 50,8 T100,12" fill="none" stroke="#a855f7" stroke-width="2"/>
            </svg>
        </div>
    </div>

    <!-- Oil Price (Brent) -->
    <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
        <div class="gsc-mini-stat">
            <div class="d-flex justify-content-between align-items-center">
                <span class="gsc-mini-title"><i class="fas fa-tint text-warning mr-1"></i> Oil Price (Brent)</span>
                <span class="text-warning font-weight-bold" style="font-size: 0.72rem; white-space: nowrap;"><i class="fas fa-arrow-up mr-1"></i> 2.1% vs last month</span>
            </div>
            <div class="gsc-mini-val">$82.45</div>
            <svg height="20" width="100%" viewBox="0 0 100 25" preserveAspectRatio="none">
                <path d="M0,22 Q25,10 50,18 T100,8" fill="none" stroke="#f59e0b" stroke-width="2"/>
            </svg>
        </div>
    </div>

    <!-- Global Trade Index -->
    <div class="col-lg-3 col-md-6">
        <div class="gsc-mini-stat">
            <div class="d-flex justify-content-between align-items-center">
                <span class="gsc-mini-title"><i class="fas fa-boxes text-primary mr-1"></i> Global Trade Index</span>
                <span class="text-primary font-weight-bold" style="font-size: 0.72rem; white-space: nowrap;"><i class="fas fa-arrow-up mr-1"></i> 0.7% vs last month</span>
            </div>
            <div class="gsc-mini-val">112.7</div>
            <svg height="20" width="100%" viewBox="0 0 100 25" preserveAspectRatio="none">
                <path d="M0,18 Q25,8 50,12 T100,5" fill="none" stroke="#3b82f6" stroke-width="2"/>
            </svg>
        </div>
    </div>
</div>

<!-- Bottom Section Row 3 (4 Equal Columns x 3 Grid = 12 Total) -->
<div class="row">
    <!-- Risk Score Trend (Global Average) Line Chart (Col-lg-3) -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Risk Score Trend</h5>
                <select class="custom-select custom-select-sm py-0 px-1" style="width: 72px; height: 26px; font-size: 0.72rem; border-radius: 4px;">
                    <option>7 Days</option>
                    <option>30 Days</option>
                </select>
            </div>
            <div class="p-2">
                <div style="height: 210px; position: relative;">
                    <canvas id="riskTrendLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Currency Movement (USD) (Col-lg-3) -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Currency Movement (USD)</h5>
            </div>
            <div class="p-0">
                <table class="table table-sm gsc-table mb-0">
                    <tbody>
                        @foreach($liveRates as $code => $info)
                        <tr>
                            <td class="font-weight-bold text-dark pl-3" style="width: 30%;">{{ $code }}</td>
                            <td style="width: 35%;">{{ number_format($info['rate'], 2) }}</td>
                            <td class="text-success text-right pr-3" style="width: 35%;"><i class="fas fa-arrow-up mr-1"></i> {{ $info['change'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Risk Distribution Donut Chart (Col-lg-3) -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">Risk Distribution</h5>
            </div>
            <div class="p-2 d-flex flex-column align-items-center justify-content-center">
                <div style="height: 190px; width: 100%; position: relative;">
                    <canvas id="riskDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- My WatchList (Col-lg-3) -->
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="gsc-panel h-100">
            <div class="gsc-panel-header">
                <h5 class="gsc-panel-title">My WatchList</h5>
                <a href="{{ route('favorites.index') }}" class="gsc-view-all">View all</a>
            </div>
            <div class="p-0">
                <table class="table table-sm gsc-table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th class="pl-3" style="width: 50%;">Country</th>
                            <th class="text-center" style="width: 25%;">Score</th>
                            <th class="text-right pr-3" style="width: 25%;">Change</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($watchlistCountries as $item)
                        @php
                            $flagUrl = "https://flagcdn.com/w40/" . strtolower($item->code) . ".png";
                            $changeVal = rand(1, 5);
                            $isUp = rand(0, 1);
                        @endphp
                        <tr>
                            <td class="pl-3">
                                <div class="d-flex align-items-center" style="min-width: 0;">
                                    <i class="fas fa-star text-warning mr-1 flex-shrink-0" style="font-size:0.75rem;"></i>
                                    <img src="{{ $flagUrl }}" class="rounded mr-1 flex-shrink-0" style="width:16px; height:11px; object-fit:cover;">
                                    <strong class="text-dark text-truncate">{{ $item->name }}</strong>
                                </div>
                            </td>
                            <td class="text-center font-weight-bold">{{ $item->risk_score }}</td>
                            <td class="text-right pr-3 {{ $isUp ? 'text-danger' : 'text-success' }}">
                                <i class="fas {{ $isUp ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i> {{ $changeVal }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted py-3">No watchlist countries</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Footer Credit Bar -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-center py-3 border-top text-muted" style="font-size:0.78rem;">
    <div>
        &copy; {{ date('Y') }} <strong>Global Supply Chain Risk Intelligence Platform</strong>. All rights reserved.
    </div>
    <div class="mt-1 mt-md-0">
        Data Sources: <span class="text-dark font-weight-bold">Open-Meteo, World Bank, REST Countries, ExchangeRate, GNews, World Port Index</span>
    </div>
</div>

@stop

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Initialize Leaflet World Map
    var map = L.map('worldMap', { zoomControl: false }).setView([20, 15], 1.8);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        maxZoom: 18,
        attribution: '&copy; CARTO'
    }).addTo(map);

    L.control.zoom({ position: 'topleft' }).addTo(map);

    @foreach($mapCountries as $country)
    @if($country->latitude && $country->longitude)
    (function() {
        var color = '#10b981';
        @if($country->risk_score >= 60)
            color = '#ef4444';
        @elseif($country->risk_score >= 35)
            color = '#f59e0b';
        @endif

        L.circleMarker([{{ $country->latitude }}, {{ $country->longitude }}], {
            radius: 6,
            color: '#ffffff',
            weight: 1.5,
            fillColor: color,
            fillOpacity: 0.9
        }).addTo(map).bindPopup(`
            <div style="font-family: 'Plus Jakarta Sans', sans-serif;">
                <strong>${'{{ $country->name }}'}</strong><br>
                Risk Score: <strong>${'{{ $country->risk_score }}'}%</strong>
            </div>
        `);
    })();
    @endif
    @endforeach

    // 2. Risk Score Trend (Global Average) Line Chart
    const lineCtx = document.getElementById('riskTrendLineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['17 May', '18 May', '19 May', '20 May', '21 May', '22 May', '23 May'],
            datasets: [{
                label: 'Global Risk Trend',
                data: [32, 45, 38, 52, 41, 48, 34.7],
                borderColor: '#3b82f6',
                borderWidth: 2.5,
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                pointRadius: 3,
                pointBackgroundColor: '#3b82f6'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: { padding: { left: 5, right: 10, top: 10, bottom: 5 } },
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { beginAtZero: false, min: 20, max: 80, ticks: { font: { size: 10 } } }
            }
        }
    });

    // 3. Risk Distribution Donut / Ring Chart
    const donutCtx = document.getElementById('riskDonutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: [
                'High Risk: {{ $highRisk }}', 
                'Medium Risk: {{ $mediumRisk }}', 
                'Low Risk: {{ $lowRisk }}'
            ],
            datasets: [{
                data: [{{ $highRisk }}, {{ $mediumRisk }}, {{ $lowRisk }}],
                backgroundColor: ['#ef4444', '#f59e0b', '#10b981'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { size: 9.5, weight: '700', family: "'Plus Jakarta Sans', sans-serif" },
                        boxWidth: 8,
                        padding: 6
                    }
                }
            }
        }
    });

    // 4. Global Search Redirect Handler
    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter' && this.value.trim() !== '') {
                window.location.href = `{{ route('countries.index') }}?search=${encodeURIComponent(this.value.trim())}`;
            }
        });
    }
});
</script>
@stop