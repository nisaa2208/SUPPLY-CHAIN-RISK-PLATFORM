@extends('adminlte::page')

@section('title', 'Berita Global Real-Time & Lexicon Sentiment')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-newspaper text-indigo mr-2"></i>
            Berita Global Real-Time (GNews API)
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Live Global Supply Chain News, Category Tabs, Country Filters & Lexicon Sentiment Analysis
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span id="liveApiStatus" class="badge badge-success px-3 py-2 mr-2" style="font-size:0.85rem;">
            <i class="fas fa-satellite-dish mr-1"></i> Live GNews API
        </span>

        <button id="btnRefreshNews" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
            <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh Berita
        </button>
    </div>
</div>
@stop

@section('css')
<style>
.news-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    border-radius: var(--radius-md);
    overflow: hidden;
}
.news-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg) !important;
}
.news-thumbnail {
    height: 185px;
    object-fit: cover;
    width: 100%;
    border-top-left-radius: var(--radius-md);
    border-top-right-radius: var(--radius-md);
}
.category-pill {
    cursor: pointer;
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
}
.category-pill.active {
    background: #6366f1;
    color: #ffffff;
    border-color: #6366f1;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}
.category-pill:hover:not(.active) {
    background: #f1f5f9;
    color: #0f172a;
}
</style>
@stop

@section('content')

<!-- Interactive Category Tabs/Pills Row -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div class="d-flex flex-wrap gap-2 mb-2 mb-md-0" id="categoryPillsGroup">
                <span class="category-pill active" data-category="">
                    <i class="fas fa-globe mr-1"></i> Semua Kategori (Global)
                </span>
                <span class="category-pill" data-category="logistics">
                    <i class="fas fa-boxes mr-1"></i> Logistics & Supply Chain
                </span>
                <span class="category-pill" data-category="trade">
                    <i class="fas fa-handshake mr-1"></i> International Trade
                </span>
                <span class="category-pill" data-category="shipping">
                    <i class="fas fa-ship mr-1"></i> Maritime Shipping & Ports
                </span>
                <span class="category-pill" data-category="economy">
                    <i class="fas fa-chart-line mr-1"></i> Global Economy
                </span>
            </div>

            <!-- Country Selector Dropdown -->
            <div style="min-width: 220px;">
                <select id="countryFilter" class="form-control custom-select">
                    <option value="">🌍 Semua Negara (Global)</option>
                    <option value="us">🇺🇸 United States (US)</option>
                    <option value="gb">🇬🇧 United Kingdom (GB)</option>
                    <option value="id">🇮🇩 Indonesia (ID)</option>
                    <option value="cn">🇨🇳 China (CN)</option>
                    <option value="de">🇩🇪 Germany (DE)</option>
                    <option value="jp">🇯🇵 Japan (JP)</option>
                    <option value="in">🇮🇳 India (IN)</option>
                    <option value="au">🇦🇺 Australia (AU)</option>
                    <option value="sg">🇸🇬 Singapore (SG)</option>
                    <option value="ca">🇨🇦 Canada (CA)</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Keyword Search Input & Refresh Bar -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-9 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="newsSearchInput" class="form-control border-left-0" placeholder="Cari kata kunci berita spesifik (e.g. port congestion, tariff, inflation, freight)...">
                </div>
            </div>

            <div class="col-md-3">
                <button type="button" id="btnApplySearch" class="btn btn-indigo btn-block font-weight-bold text-white shadow-sm" style="background-color:#6366f1;">
                    <i class="fas fa-search mr-1"></i> Cari Berita Live
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Alert Banner For Error Handling -->
<div id="newsErrorAlert" class="alert alert-danger shadow-sm border-0 d-none" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i> <span id="newsErrorMessage">Gagal mengambil berita terbaru dari GNews API.</span>
</div>

<!-- Sentiment Overview & Donut Chart Row -->
<div class="row mb-4">
    <!-- Stat Cards -->
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-dark text-white p-3 h-100" style="border-radius: var(--radius-md);">
                    <small class="text-warning font-weight-bold d-block text-uppercase">TOTAL BERITA DIPANTAU</small>
                    <div class="h2 font-weight-bold text-white mb-1" id="statTotalArticles">0 Berita</div>
                    <small class="text-light" id="statEngineLabel">Source: GNews API Real-Time</small>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-light p-3 h-100 border-left border-success" style="border-left-width: 4px !important; border-radius: var(--radius-md);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold d-block">SENTIMEN POSITIF</small>
                            <div class="h3 font-weight-bold text-success mb-0" id="statPosPercent">0%</div>
                            <small class="text-muted" id="statPosCount">0 berita positif</small>
                        </div>
                        <i class="fas fa-smile fa-2x text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-light p-3 h-100 border-left border-secondary" style="border-left-width: 4px !important; border-radius: var(--radius-md);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold d-block">SENTIMEN NETRAL</small>
                            <div class="h3 font-weight-bold text-secondary mb-0" id="statNeuPercent">0%</div>
                            <small class="text-muted" id="statNeuCount">0 berita netral</small>
                        </div>
                        <i class="fas fa-meh fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-light p-3 h-100 border-left border-danger" style="border-left-width: 4px !important; border-radius: var(--radius-md);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold d-block">SENTIMEN NEGATIF</small>
                            <div class="h3 font-weight-bold text-danger mb-0" id="statNegPercent">0%</div>
                            <small class="text-muted" id="statNegCount">0 berita negatif</small>
                        </div>
                        <i class="fas fa-frown fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sentiment Donut Chart -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-indigo mr-2"></i> Analisis Sentimen (Lexicon Engine)
                </h5>
            </div>
            <div class="card-body p-3">
                <div style="height: 180px; position: relative;">
                    <canvas id="sentimentDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Spinner Container -->
<div id="newsLoadingSpinner" class="text-center py-5 d-none">
    <div class="spinner-border text-indigo mb-2" role="status" style="width: 3rem; height: 3rem; color: #6366f1;"></div>
    <div class="text-muted font-weight-bold mt-2">Mengambil berita real-time dari GNews API...</div>
</div>

<!-- News Cards Grid View Container -->
<div class="row" id="newsGridContainer">
    <!-- Dynamic News Cards rendered via JS -->
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let activeCategory = '';
    let sentimentChart = null;

    // Initialize Chart.js Donut Chart
    function initSentimentChart() {
        const ctx = document.getElementById('sentimentDonutChart').getContext('2d');
        sentimentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Positif', 'Netral', 'Negatif'],
                datasets: [{
                    data: [0, 0, 0],
                    backgroundColor: ['#10b981', '#64748b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { font: { size: 11 } } }
                }
            }
        });
    }

    initSentimentChart();

    // Category Pill Click Handler
    const categoryPills = document.querySelectorAll('#categoryPillsGroup .category-pill');
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function () {
            categoryPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.getAttribute('data-category');
            fetchLiveNews();
        });
    });

    // Fetch Live News from API
    function fetchLiveNews() {
        const q = document.getElementById('newsSearchInput').value;
        const country = document.getElementById('countryFilter').value;

        document.getElementById('newsLoadingSpinner').classList.remove('d-none');
        document.getElementById('newsGridContainer').innerHTML = '';
        document.getElementById('newsErrorAlert').classList.add('d-none');
        document.getElementById('refreshSpinner').classList.add('fa-spin');

        const params = new URLSearchParams({ q: q, category: activeCategory, country: country });

        fetch(`{{ url('/api/news/live') }}?${params.toString()}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('newsLoadingSpinner').classList.add('d-none');
                document.getElementById('refreshSpinner').classList.remove('fa-spin');

                if (res.success && res.articles) {
                    updateStatsUI(res.stats, res.source_engine);
                    renderNewsCards(res.articles);
                } else {
                    showError(res.message || 'Gagal memuat berita terbaru.');
                }
            })
            .catch(err => {
                document.getElementById('newsLoadingSpinner').classList.add('d-none');
                document.getElementById('refreshSpinner').classList.remove('fa-spin');
                showError('Koneksi gagal saat terhubung ke GNews API.');
            });
    }

    // Update Statistics Cards & Donut Chart
    function updateStatsUI(stats, sourceEngine) {
        if (!stats) return;

        document.getElementById('statTotalArticles').innerText = `${stats.total} Berita`;
        document.getElementById('statEngineLabel').innerText = `Source: ${sourceEngine}`;
        document.getElementById('statPosPercent').innerText = `${stats.positive_percent}%`;
        document.getElementById('statPosCount').innerText = `${stats.positive_count} berita positif`;
        document.getElementById('statNeuPercent').innerText = `${stats.neutral_percent}%`;
        document.getElementById('statNeuCount').innerText = `${stats.neutral_count} berita netral`;
        document.getElementById('statNegPercent').innerText = `${stats.negative_percent}%`;
        document.getElementById('statNegCount').innerText = `${stats.negative_count} berita negatif`;

        if (sentimentChart) {
            sentimentChart.data.datasets[0].data = [
                stats.positive_count,
                stats.neutral_count,
                stats.negative_count
            ];
            sentimentChart.update();
        }
    }

    // Render News Cards Grid
    function renderNewsCards(articles) {
        const container = document.getElementById('newsGridContainer');

        if (!articles || articles.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-newspaper fa-4x mb-3 text-muted opacity-50"></i>
                    <h5 class="font-weight-bold">Tidak Ada Berita untuk Kategori / Negara Ini</h5>
                    <p class="mb-0">Silakan pilih kategori lain atau ubah filter pencarian Anda.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = articles.map(art => {
            let sentBadge = 'badge-secondary';
            if (art.sentiment === 'Positive') {
                sentBadge = 'badge-success';
            } else if (art.sentiment === 'Negative') {
                sentBadge = 'badge-danger';
            }

            const posWords = art.matched_positive && art.matched_positive.length > 0 ? (Array.isArray(art.matched_positive) ? art.matched_positive.join(', ') : Object.values(art.matched_positive).join(', ')) : '-';
            const negWords = art.matched_negative && art.matched_negative.length > 0 ? (Array.isArray(art.matched_negative) ? art.matched_negative.join(', ') : Object.values(art.matched_negative).join(', ')) : '-';

            return `
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card news-card border shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="position-relative">
                                <img src="${art.image}" class="news-thumbnail" alt="${art.title}" onerror="this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&q=80'">
                                <span class="badge badge-dark position-absolute" style="top:10px; left:10px; font-size:0.75rem; background:rgba(15,23,42,0.85); backdrop-filter:blur(4px);">
                                    <i class="fas fa-tag text-warning mr-1"></i> ${art.category}
                                </span>
                                <span class="badge badge-light border position-absolute font-weight-bold" style="top:10px; right:10px; font-size:0.75rem;">
                                    <i class="fas fa-globe text-primary mr-1"></i> ${art.country}
                                </span>
                            </div>

                            <div class="p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size:0.8rem;">
                                    <span class="text-muted"><i class="fas fa-newspaper mr-1"></i> ${art.source.name}</span>
                                    <span class="badge ${sentBadge} font-weight-bold px-2 py-1">${art.sentiment}</span>
                                </div>

                                <h5 class="font-weight-bold text-dark mb-2" style="font-size: 1.05rem; line-height: 1.4;">
                                    ${art.title}
                                </h5>

                                <p class="text-muted mb-3" style="font-size: 0.85rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    ${art.description}
                                </p>
                            </div>
                        </div>

                        <div class="p-3 border-top bg-light">
                            <!-- Lexicon Word Matches -->
                            <div class="p-2 bg-white rounded border mb-3" style="font-size:0.78rem;">
                                <div><span class="text-success font-weight-bold">Kata Positif:</span> ${posWords}</div>
                                <div><span class="text-danger font-weight-bold">Kata Negatif:</span> ${negWords}</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><i class="fas fa-clock mr-1"></i> ${art.publishedAt}</small>
                                <a href="${art.url}" target="_blank" class="btn btn-xs btn-outline-primary font-weight-bold">
                                    Baca Selengkapnya <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    function showError(msg) {
        document.getElementById('newsErrorMessage').innerText = msg;
        document.getElementById('newsErrorAlert').classList.remove('d-none');
    }

    // Event Listeners
    document.getElementById('btnRefreshNews').addEventListener('click', fetchLiveNews);
    document.getElementById('btnApplySearch').addEventListener('click', fetchLiveNews);
    document.getElementById('countryFilter').addEventListener('change', fetchLiveNews);

    document.getElementById('newsSearchInput').addEventListener('keyup', function (e) {
        if (e.key === 'Enter') fetchLiveNews();
    });

    // Initial Fetch
    fetchLiveNews();
});
</script>
@stop