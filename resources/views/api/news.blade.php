@extends('adminlte::page')

@section('title', 'Berita Global Real-Time & Sentiment Intelligence Hub')

@section('content_header')
<!-- Empty content header because we have an integrated Hero Control Center below -->
@stop

@section('css')
<style>
/* Enterprise Hero Control Panel */
.news-hero-control-panel {
    background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
    border-radius: var(--radius-lg);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 12px 32px -4px rgba(15, 23, 42, 0.25);
    color: #ffffff;
    padding: 1.75rem;
    margin-bottom: 1.75rem;
}

.hero-glass-input {
    background: rgba(255, 255, 255, 0.95) !important;
    border: 1px solid #cbd5e1 !important;
    border-radius: var(--radius-md) !important;
    font-size: 0.95rem !important;
    color: #0f172a !important;
}

.category-pill-dark {
    cursor: pointer;
    padding: 7px 16px;
    border-radius: var(--radius-pill);
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(255, 255, 255, 0.15);
    background: rgba(255, 255, 255, 0.08);
    color: #cbd5e1;
    user-select: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}
.category-pill-dark.active {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    color: #ffffff;
    border-color: #818cf8;
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.5);
}
.category-pill-dark:hover:not(.active) {
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
    transform: translateY(-1px);
}

.topic-tag-dark {
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    padding: 3px 12px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: var(--radius-pill);
    font-size: 0.78rem;
    font-weight: 600;
    color: #cbd5e1;
    transition: all 0.2s ease;
}
.topic-tag-dark:hover {
    background: rgba(99, 102, 241, 0.3);
    color: #ffffff;
    border-color: #818cf8;
}

/* News Cards Styling */
.news-hero-card {
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.news-hero-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 18px 36px -4px rgba(15, 23, 42, 0.12) !important;
}
.news-hero-img {
    height: 320px;
    object-fit: cover;
    width: 100%;
    transition: transform 0.5s ease;
}
.news-hero-card:hover .news-hero-img {
    transform: scale(1.03);
}

.news-card {
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.28s ease, border-color 0.28s ease;
    border-radius: var(--radius-lg);
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e2e8f0;
}
.news-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 35px -8px rgba(99, 102, 241, 0.15) !important;
    border-color: #cbd5e1;
}

.news-thumbnail-wrapper {
    position: relative;
    overflow: hidden;
    height: 190px;
    background: #0f172a;
}
.news-thumbnail {
    height: 100%;
    object-fit: cover;
    width: 100%;
    transition: transform 0.4s ease;
}
.news-card:hover .news-thumbnail {
    transform: scale(1.08);
}

.lexicon-tag {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 6px;
    font-size: 0.74rem;
    font-weight: 600;
    margin: 2px 2px 2px 0;
}
.lexicon-tag-pos {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
.lexicon-tag-neg {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Sentiment Bar Indicator */
.sentiment-bar-bg {
    height: 6px;
    border-radius: 10px;
    background: #e2e8f0;
    overflow: hidden;
}
.sentiment-bar-fill {
    height: 100%;
    transition: width 0.5s ease;
}

/* Live Pulse Animation */
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
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}
</style>
@stop

@section('content')

<!-- Enterprise Hero Control Center (Unified Header, Filters & Search) -->
<div class="news-hero-control-panel">
    <!-- Header Row -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 border-bottom border-secondary pb-3" style="border-color: rgba(255,255,255,0.12) !important;">
        <div>
            <h1 class="font-weight-bold text-white mb-0" style="font-size: 1.85rem; letter-spacing: -0.02em;">
                <i class="fas fa-satellite-dish text-primary mr-2"></i>
                Real-Time News Intelligence Radar
            </h1>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span id="liveApiStatus" class="badge badge-success px-3 py-2 mr-2 shadow-sm d-inline-flex align-items-center" style="font-size:0.83rem; border-radius: var(--radius-pill); background: rgba(16,185,129,0.2); border: 1px solid rgba(16,185,129,0.4); color: #34d399;">
                <i class="fas fa-signal mr-2 fa-spin"></i> GNews API Connected
            </span>

            <button id="btnRefreshNews" class="btn btn-primary btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: var(--radius-pill); background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none;">
                <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh Berita
            </button>
        </div>
    </div>

    <!-- Search & Country Dropdown Row -->
    <div class="row align-items-center mb-3">
        <!-- Search Keyword Box -->
        <div class="col-lg-8 col-md-7 mb-2 mb-md-0">
            <div class="input-group input-group-lg" style="border-radius: var(--radius-md); overflow:hidden;">
                <div class="input-group-prepend">
                    <span class="input-group-text border-right-0" style="background:#ffffff; color:#6366f1;"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" id="newsSearchInput" class="form-control border-left-0 pl-0 hero-glass-input" placeholder="Cari kata kunci berita spesifik (e.g. port congestion, tariff, inflation, freight)...">
            </div>
        </div>

        <!-- Country Selector Dropdown -->
        <div class="col-lg-4 col-md-5">
            <div class="d-flex align-items-center gap-2">
                <select id="countryFilter" class="custom-select custom-select-lg shadow-sm" style="border-radius: var(--radius-md); font-weight:600; background-color:#ffffff; color:#0f172a; padding-right:2.5rem !important;">
                    <option value="">🌍 Semua Negara (Global Feed)</option>
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

                <button type="button" id="btnApplySearch" class="btn btn-indigo font-weight-bold px-3 text-white shadow-sm" style="background:#6366f1; border-radius: var(--radius-md); white-space: nowrap; height: 46px;">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Category Pills & Trending Topics Row -->
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 pt-2">
        <!-- Category Pills -->
        <div class="d-flex flex-wrap gap-2" id="categoryPillsGroup">
            <span class="category-pill-dark active" data-category="">
                <i class="fas fa-globe"></i> Semua Kategori
            </span>
            <span class="category-pill-dark" data-category="logistics">
                <i class="fas fa-boxes"></i> Logistics & Supply Chain
            </span>
            <span class="category-pill-dark" data-category="trade">
                <i class="fas fa-handshake"></i> International Trade
            </span>
            <span class="category-pill-dark" data-category="shipping">
                <i class="fas fa-ship"></i> Maritime Shipping & Ports
            </span>
            <span class="category-pill-dark" data-category="economy">
                <i class="fas fa-chart-line"></i> Global Economy
            </span>
        </div>

        <!-- Trending Topics Strip -->
        <div class="d-flex align-items-center flex-wrap gap-1">
            <small class="font-weight-bold text-light opacity-75 text-uppercase mr-1" style="font-size:0.75rem;">
                <i class="fas fa-fire text-warning mr-1"></i> Trending:
            </small>
            <span class="topic-tag-dark" data-tag="port congestion">#PortCongestion</span>
            <span class="topic-tag-dark" data-tag="Suez Canal">#SuezCanal</span>
            <span class="topic-tag-dark" data-tag="Red Sea">#RedSea</span>
            <span class="topic-tag-dark" data-tag="tariffs">#Tariffs</span>
            <span class="topic-tag-dark" data-tag="freight rates">#FreightRates</span>
            <span class="topic-tag-dark" data-tag="inflation">#Inflation</span>
        </div>
    </div>
</div>

<!-- Alert Banner For Error Handling -->
<div id="newsErrorAlert" class="alert alert-danger shadow-sm border-0 d-none" role="alert" style="border-radius: var(--radius-md);">
    <i class="fas fa-exclamation-triangle mr-2"></i> <span id="newsErrorMessage">Gagal mengambil berita terbaru dari GNews API.</span>
</div>

<!-- Sentiment Overview & Donut Chart Panel Row -->
<div class="row mb-4">
    <!-- Stat Summary Cards (4 Column Grid) -->
    <div class="col-lg-8 mb-3 mb-lg-0">
        <div class="row">
            <!-- Total Articles -->
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm text-white p-3 h-100" style="border-radius: var(--radius-lg); background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <small class="text-warning font-weight-bold text-uppercase" style="letter-spacing: 0.05em; font-size: 0.75rem;">TOTAL BERITA DIPANTAU</small>
                        <i class="fas fa-newspaper fa-2x text-warning opacity-75"></i>
                    </div>
                    <div class="h2 font-weight-bold text-white mb-1" id="statTotalArticles">0 Berita</div>
                    <small class="text-light opacity-75" id="statEngineLabel">Source: GNews API Real-Time</small>
                </div>
            </div>

            <!-- Positif -->
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm bg-white p-3 h-100 border-left border-success" style="border-left-width: 5px !important; border-radius: var(--radius-lg);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">SENTIMEN POSITIF</small>
                            <div class="h3 font-weight-bold text-success mb-0" id="statPosPercent">0%</div>
                            <small class="text-muted font-weight-bold" id="statPosCount">0 berita positif</small>
                        </div>
                        <div class="p-3 bg-light rounded-circle text-success">
                            <i class="fas fa-smile fa-2x"></i>
                        </div>
                    </div>
                    <div class="sentiment-bar-bg mt-3">
                        <div id="barPosFill" class="sentiment-bar-fill bg-success" style="width: 0%;"></div>
                    </div>
                </div>
            </div>

            <!-- Netral -->
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card border-0 shadow-sm bg-white p-3 h-100 border-left border-secondary" style="border-left-width: 5px !important; border-radius: var(--radius-lg);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">SENTIMEN NETRAL</small>
                            <div class="h3 font-weight-bold text-secondary mb-0" id="statNeuPercent">0%</div>
                            <small class="text-muted font-weight-bold" id="statNeuCount">0 berita netral</small>
                        </div>
                        <div class="p-3 bg-light rounded-circle text-secondary">
                            <i class="fas fa-meh fa-2x"></i>
                        </div>
                    </div>
                    <div class="sentiment-bar-bg mt-3">
                        <div id="barNeuFill" class="sentiment-bar-fill bg-secondary" style="width: 0%;"></div>
                    </div>
                </div>
            </div>

            <!-- Negatif -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm bg-white p-3 h-100 border-left border-danger" style="border-left-width: 5px !important; border-radius: var(--radius-lg);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">SENTIMEN NEGATIF</small>
                            <div class="h3 font-weight-bold text-danger mb-0" id="statNegPercent">0%</div>
                            <small class="text-muted font-weight-bold" id="statNegCount">0 berita negatif</small>
                        </div>
                        <div class="p-3 bg-light rounded-circle text-danger">
                            <i class="fas fa-frown fa-2x"></i>
                        </div>
                    </div>
                    <div class="sentiment-bar-bg mt-3">
                        <div id="barNegFill" class="sentiment-bar-fill bg-danger" style="width: 0%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sentiment Donut Chart Panel -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100" style="border-radius: var(--radius-lg);">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-chart-pie text-primary mr-2"></i> Analisis Sentimen (Lexicon Engine)
                </h5>
            </div>
            <div class="card-body p-3 d-flex align-items-center justify-content-center">
                <div style="height: 210px; width: 100%; position: relative;">
                    <canvas id="sentimentDonutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Skeleton & Spinner Container -->
<div id="newsLoadingSpinner" class="text-center py-5 d-none">
    <div class="spinner-border text-primary mb-3" role="status" style="width: 3.2rem; height: 3.2rem;"></div>
    <h5 class="font-weight-bold text-dark">Mengambil Berita Live & Menjalankan Analisis Sentimen Lexicon...</h5>
    <p class="text-muted mb-0">GNews Real-Time API Engine sedang memproses artikel...</p>
</div>

<!-- Hero Featured Story Container -->
<div id="heroNewsContainer" class="mb-4"></div>

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
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12, weight: '600' },
                            padding: 15
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    initSentimentChart();

    // Category Pill Click Handler
    const categoryPills = document.querySelectorAll('#categoryPillsGroup .category-pill-dark');
    categoryPills.forEach(pill => {
        pill.addEventListener('click', function () {
            categoryPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeCategory = this.getAttribute('data-category');
            fetchLiveNews();
        });
    });

    // Topic Tags Click Handler
    const topicTags = document.querySelectorAll('.topic-tag-dark');
    topicTags.forEach(tag => {
        tag.addEventListener('click', function () {
            const query = this.getAttribute('data-tag');
            document.getElementById('newsSearchInput').value = query;
            fetchLiveNews();
        });
    });

    // Fetch Live News from API Endpoint
    function fetchLiveNews() {
        const q = document.getElementById('newsSearchInput').value;
        const country = document.getElementById('countryFilter').value;

        document.getElementById('newsLoadingSpinner').classList.remove('d-none');
        document.getElementById('newsGridContainer').innerHTML = '';
        document.getElementById('heroNewsContainer').innerHTML = '';
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
        document.getElementById('statEngineLabel').innerText = `Engine: ${sourceEngine}`;
        document.getElementById('statPosPercent').innerText = `${stats.positive_percent}%`;
        document.getElementById('statPosCount').innerText = `${stats.positive_count} berita positif`;
        document.getElementById('statNeuPercent').innerText = `${stats.neutral_percent}%`;
        document.getElementById('statNeuCount').innerText = `${stats.neutral_count} berita netral`;
        document.getElementById('statNegPercent').innerText = `${stats.negative_percent}%`;
        document.getElementById('statNegCount').innerText = `${stats.negative_count} berita negatif`;

        // Progress bar updates
        const posFill = document.getElementById('barPosFill');
        const neuFill = document.getElementById('barNeuFill');
        const negFill = document.getElementById('barNegFill');

        if (posFill) posFill.style.width = `${stats.positive_percent}%`;
        if (neuFill) neuFill.style.width = `${stats.neutral_percent}%`;
        if (negFill) negFill.style.width = `${stats.negative_percent}%`;

        if (sentimentChart) {
            sentimentChart.data.datasets[0].data = [
                stats.positive_count,
                stats.neutral_count,
                stats.negative_count
            ];
            sentimentChart.update();
        }
    }

    // Render News Cards Grid (with Featured Story)
    function renderNewsCards(articles) {
        const heroContainer = document.getElementById('heroNewsContainer');
        const gridContainer = document.getElementById('newsGridContainer');

        if (!articles || articles.length === 0) {
            gridContainer.innerHTML = `
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-newspaper fa-4x mb-3 text-muted opacity-50"></i>
                    <h5 class="font-weight-bold">Tidak Ada Berita untuk Kategori / Negara Ini</h5>
                    <p class="mb-0">Silakan pilih kategori lain atau ubah kata kunci pencarian Anda.</p>
                </div>
            `;
            return;
        }

        // Separate Featured Hero Article (First Item)
        const hero = articles[0];
        const remaining = articles.slice(1);

        // Render Hero Featured Story
        if (hero) {
            let heroBadgeClass = 'badge-secondary';
            let heroIcon = 'fa-meh';
            if (hero.sentiment === 'Positive') { heroBadgeClass = 'badge-success'; heroIcon = 'fa-smile'; }
            else if (hero.sentiment === 'Negative') { heroBadgeClass = 'badge-danger'; heroIcon = 'fa-frown'; }

            const posWordsHtml = buildLexiconTags(hero.matched_positive, 'pos');
            const negWordsHtml = buildLexiconTags(hero.matched_negative, 'neg');

            heroContainer.innerHTML = `
                <div class="news-hero-card shadow-sm">
                    <div class="row no-gutters align-items-center">
                        <div class="col-lg-6">
                            <div class="news-thumbnail-wrapper" style="height: 100%; min-height: 280px;">
                                <img src="${hero.image}" class="news-hero-img" alt="${hero.title}" onerror="this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&q=80'">
                                <span class="badge badge-warning text-dark position-absolute font-weight-bold px-3 py-2" style="top:15px; left:15px; font-size:0.8rem; border-radius: var(--radius-pill);">
                                    <i class="fas fa-fire mr-1"></i> TOP FEATURED STORY
                                </span>
                            </div>
                        </div>
                        <div class="col-lg-6 p-4 p-md-5">
                            <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 0.85rem;">
                                <span class="badge badge-indigo text-white px-3 py-1 font-weight-bold" style="background:#6366f1; border-radius: var(--radius-pill);">${hero.category}</span>
                                <span class="text-muted"><i class="fas fa-globe text-primary mr-1"></i> ${hero.country}</span>
                                <span class="text-muted mx-1">&bull;</span>
                                <span class="text-muted"><i class="fas fa-newspaper mr-1"></i> ${hero.source.name}</span>
                            </div>

                            <h3 class="font-weight-bold text-dark mb-3" style="line-height: 1.35; letter-spacing:-0.02em;">
                                <a href="${hero.url}" target="_blank" class="text-dark hover:text-primary">${hero.title}</a>
                            </h3>

                            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                                ${hero.description}
                            </p>

                            <!-- Lexicon Sentiment Box -->
                            <div class="p-3 rounded border bg-light mb-4" style="font-size: 0.82rem;">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <strong class="text-dark"><i class="fas fa-calculator text-primary mr-1"></i> Lexicon Analysis:</strong>
                                    <span class="badge ${heroBadgeClass} font-weight-bold px-3 py-1" style="font-size: 0.8rem; border-radius: var(--radius-pill);">
                                        <i class="fas ${heroIcon} mr-1"></i> ${hero.sentiment}
                                    </span>
                                </div>
                                <div><span class="text-success font-weight-bold mr-1">Positif:</span> ${posWordsHtml}</div>
                                <div class="mt-1"><span class="text-danger font-weight-bold mr-1">Negatif:</span> ${negWordsHtml}</div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted"><i class="far fa-clock mr-1"></i> ${hero.publishedAt}</small>
                                <a href="${hero.url}" target="_blank" class="btn btn-primary font-weight-bold shadow-sm px-4">
                                    Baca Artikel Lengkap <i class="fas fa-external-link-alt ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Render Remaining Grid Cards
        gridContainer.innerHTML = remaining.map(art => {
            let sentBadge = 'badge-secondary';
            let sentIcon = 'fa-meh';
            if (art.sentiment === 'Positive') { sentBadge = 'badge-success'; sentIcon = 'fa-smile'; }
            else if (art.sentiment === 'Negative') { sentBadge = 'badge-danger'; sentIcon = 'fa-frown'; }

            const posTags = buildLexiconTags(art.matched_positive, 'pos');
            const negTags = buildLexiconTags(art.matched_negative, 'neg');

            return `
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card news-card shadow-sm h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="news-thumbnail-wrapper">
                                <img src="${art.image}" class="news-thumbnail" alt="${art.title}" onerror="this.src='https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600&q=80'">
                                <span class="badge badge-dark position-absolute font-weight-bold" style="top:12px; left:12px; font-size:0.75rem; background:rgba(15,23,42,0.85); backdrop-filter:blur(4px); border-radius: var(--radius-pill);">
                                    <i class="fas fa-tag text-warning mr-1"></i> ${art.category}
                                </span>
                                <span class="badge badge-light border position-absolute font-weight-bold shadow-sm" style="top:12px; right:12px; font-size:0.75rem; border-radius: var(--radius-pill);">
                                    <i class="fas fa-globe text-primary mr-1"></i> ${art.country}
                                </span>
                            </div>

                            <div class="p-3 p-md-4">
                                <div class="d-flex justify-content-between align-items-center mb-2" style="font-size:0.8rem;">
                                    <span class="text-muted font-weight-bold"><i class="fas fa-newspaper text-secondary mr-1"></i> ${art.source.name}</span>
                                    <span class="badge ${sentBadge} font-weight-bold px-2 py-1" style="border-radius: var(--radius-pill);">
                                        <i class="fas ${sentIcon} mr-1"></i> ${art.sentiment}
                                    </span>
                                </div>

                                <h5 class="font-weight-bold text-dark mb-2" style="font-size: 1.02rem; line-height: 1.45;">
                                    <a href="${art.url}" target="_blank" class="text-dark hover:text-primary">${art.title}</a>
                                </h5>

                                <p class="text-muted mb-3" style="font-size: 0.86rem; line-height: 1.55; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                    ${art.description}
                                </p>
                            </div>
                        </div>

                        <div class="p-3 border-top bg-light" style="border-bottom-left-radius: var(--radius-lg); border-bottom-right-radius: var(--radius-lg);">
                            <!-- Lexicon Word Matches -->
                            <div class="p-2 bg-white rounded border mb-3" style="font-size:0.78rem;">
                                <div><strong class="text-success">Positif:</strong> ${posTags}</div>
                                <div class="mt-1"><strong class="text-danger">Negatif:</strong> ${negTags}</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted font-weight-bold"><i class="far fa-clock mr-1"></i> ${art.publishedAt}</small>
                                <a href="${art.url}" target="_blank" class="btn btn-xs btn-outline-primary font-weight-bold px-3 py-1">
                                    Baca Artikel <i class="fas fa-external-link-alt ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }

    // Helper to format lexicon words into styled badge tags
    function buildLexiconTags(words, type) {
        if (!words) return '<span class="text-muted">-</span>';
        let arr = [];
        if (Array.isArray(words)) {
            arr = words;
        } else if (typeof words === 'object') {
            arr = Object.values(words);
        }

        if (arr.length === 0) return '<span class="text-muted">-</span>';

        const tagClass = type === 'pos' ? 'lexicon-tag-pos' : 'lexicon-tag-neg';
        return arr.map(w => `<span class="lexicon-tag ${tagClass}">${w}</span>`).join(' ');
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

    // Initial Fetch on Load
    fetchLiveNews();
});
</script>
@stop