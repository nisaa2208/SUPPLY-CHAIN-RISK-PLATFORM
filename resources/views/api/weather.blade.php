@extends('adminlte::page')

@section('title', 'Monitoring Cuaca Real-Time')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-cloud-sun text-warning mr-2"></i>
            Monitoring Cuaca Real-Time Global
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Live Weather Conditions, Satellite Wind Speed & Supply Chain Climate Risk Index (Open-Meteo API)
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <span id="liveStatusBadge" class="badge badge-success px-3 py-2 mr-2" style="font-size:0.85rem;">
            <i class="fas fa-wifi mr-1"></i> Live API Online
        </span>

        <button id="btnRefreshWeather" class="btn btn-warning btn-sm shadow-sm font-weight-bold">
            <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh Data
        </button>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<style>
#weatherMap {
    height: 480px;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
    border: 1px solid #e2e8f0;
}
.weather-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.weather-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg) !important;
}
.temp-display {
    font-size: 3.2rem;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1;
}
</style>
@stop

@section('content')

<!-- Alert Banner For Error Handling -->
<div id="weatherErrorAlert" class="alert alert-danger shadow-sm border-0 d-none" role="alert">
    <i class="fas fa-exclamation-triangle mr-2"></i> <span id="weatherErrorMessage">Gagal mengambil data cuaca terbaru dari Open-Meteo API.</span>
</div>

<!-- Summary Metrics Cards Row -->
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3 id="statTotalCountries">{{ $countries->count() }}</h3>
                <p>Negara Dipantau</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe-americas"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3 id="statAvgTemp">-- °C</h3>
                <p>Rata-Rata Suhu Global</p>
            </div>
            <div class="icon">
                <i class="fas fa-temperature-high"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3 id="statHighRisk">--</h3>
                <p>Peringatan Badai / Risikio Tinggi</p>
            </div>
            <div class="icon">
                <i class="fas fa-bolt"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3 id="statMaxWind">-- km/h</h3>
                <p>Kecepatan Angin Maksimum</p>
            </div>
            <div class="icon">
                <i class="fas fa-wind"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-3 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="searchInput" class="form-control border-left-0" placeholder="Cari nama negara / kode...">
                </div>
            </div>

            <div class="col-md-3 mb-2 mb-md-0">
                <select id="regionFilter" class="form-control custom-select">
                    <option value="">-- Semua Wilayah --</option>
                    @foreach($regions as $region)
                        <option value="{{ $region }}">{{ $region }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-2 mb-md-0">
                <select id="riskFilter" class="form-control custom-select">
                    <option value="">-- Semua Risk Level --</option>
                    <option value="High Risk">High Risk (Badai / Angin Kencang)</option>
                    <option value="Medium Risk">Medium Risk (Hujan / Angin Sedang)</option>
                    <option value="Low Risk">Low Risk (Cerah / Normal)</option>
                </select>
            </div>

            <div class="col-md-3 text-md-right">
                <div class="btn-group w-100" role="group">
                    <button type="button" id="btnViewSingle" class="btn btn-primary active font-weight-bold">
                        <i class="fas fa-map-marker-alt mr-1"></i> Detail Peta
                    </button>
                    <button type="button" id="btnViewAll" class="btn btn-outline-primary font-weight-bold">
                        <i class="fas fa-th-large mr-1"></i> SEMUA Negara
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Single Country View Container (Map + Detail Panel + Chart) -->
<div id="singleCountryView">
    <div class="row">
        <!-- Interactive Leaflet Weather Map -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-map-marked-alt text-warning mr-2"></i> Peta Interaktif Cuaca Dunia
                    </h3>
                    <small class="text-muted"><i class="fas fa-info-circle mr-1"></i> Klik marker negara untuk detail cuaca</small>
                </div>
                <div class="card-body p-2">
                    <div id="weatherMap"></div>
                </div>
            </div>
        </div>

        <!-- Active Selected Country Detail Panel & Chart -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold text-dark mb-0" id="activeCountryHeader">
                        <i class="fas fa-flag text-primary mr-2"></i> Detail Cuaca Negara
                    </h3>
                    <span id="activeRiskBadge" class="badge badge-success px-3 py-1" style="font-size:0.82rem;">Low Risk</span>
                </div>

                <div class="card-body p-4">
                    <div id="weatherLoadingSpinner" class="text-center py-5 d-none">
                        <div class="spinner-border text-warning mb-2" role="status"></div>
                        <div class="text-muted font-weight-bold">Mengambil data cuaca Open-Meteo...</div>
                    </div>

                    <div id="activeWeatherContent">
                        <!-- Header & Temperature -->
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div>
                                <h3 class="font-weight-bold text-dark mb-0" id="activeCountryName">Pilih Negara</h3>
                                <small class="text-muted" id="activeCountryRegion">Klik marker peta atau pilih dari dropdown</small>
                            </div>
                            <div class="text-right">
                                <i id="activeWeatherIcon" class="fas fa-sun fa-3x text-warning"></i>
                            </div>
                        </div>

                        <div class="row align-items-center mb-4">
                            <div class="col-6">
                                <div class="temp-display text-primary" id="activeTemp">--°C</div>
                                <div class="font-weight-bold text-muted mt-1" id="activeCondition">Mulai Memuat Data...</div>
                            </div>
                            <div class="col-6 border-left">
                                <div class="mb-2">
                                    <small class="text-muted d-block">Waktu Update:</small>
                                    <strong class="text-dark" id="activeUpdateTime">--:--:--</strong>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Tingkat Risiko Cuaca:</small>
                                    <strong id="activeRiskText" class="text-success">Rendah</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Weather Parameters Grid -->
                        <div class="row text-center mb-4">
                            <div class="col-4">
                                <div class="p-2 rounded bg-light border">
                                    <i class="fas fa-wind text-info mb-1"></i>
                                    <small class="d-block text-muted">Angin</small>
                                    <strong class="text-dark" id="activeWind">-- km/h</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-light border">
                                    <i class="fas fa-tint text-primary mb-1"></i>
                                    <small class="d-block text-muted">Kelembaban</small>
                                    <strong class="text-dark" id="activeHumidity">--%</strong>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded bg-light border">
                                    <i class="fas fa-cloud-rain text-primary mb-1"></i>
                                    <small class="d-block text-muted">Curah Hujan</small>
                                    <strong class="text-dark" id="activePrecip">-- mm</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Weather Risk Advisory Note -->
                        <div class="alert alert-light border shadow-sm mb-4" id="activeRiskAlertBox">
                            <small class="font-weight-bold d-block text-dark mb-1"><i class="fas fa-shield-alt text-primary mr-1"></i> Catatan Dampak Logistik:</small>
                            <small class="text-muted" id="activeRiskNote">Pilih negara untuk melihat rekomendasi dampak cuaca pada rute logistik.</small>
                        </div>

                        <!-- Hourly Temperature Trend Chart -->
                        <div class="card border-0 bg-light p-2">
                            <div class="font-weight-bold text-dark mb-2" style="font-size: 0.85rem;">
                                <i class="fas fa-chart-line text-warning mr-1"></i> Grafik Prakiraan Tren Suhu (12 Jam)
                            </div>
                            <div style="height: 150px; position: relative;">
                                <canvas id="temperatureChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- "SEMUA Negara" Grid View Container -->
<div id="allCountriesView" class="d-none">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold text-dark mb-0">
                <i class="fas fa-th-large text-primary mr-2"></i> Pemantauan Cuaca SEMUA Negara
            </h3>
            <span class="badge badge-primary px-3 py-1" id="allCountriesBadge">0 Negara</span>
        </div>
        <div class="card-body p-4">
            <div id="allCountriesLoading" class="text-center py-5">
                <div class="spinner-border text-primary mb-2"></div>
                <div class="text-muted font-weight-bold">Mengambil data cuaca seluruh negara dari Open-Meteo API...</div>
            </div>

            <div class="row" id="allCountriesGrid">
                <!-- Dynamic Weather Cards inserted via JavaScript -->
            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let map = null;
    let markersGroup = L.layerGroup();
    let tempChart = null;
    let allWeatherData = [];
    let initialCountries = @json($countries);
    let selectedCountryId = initialCountries.length > 0 ? initialCountries[0].id : null;

    // Initialize Leaflet Map
    function initMap() {
        if (!document.getElementById('weatherMap')) return;
        
        map = L.map('weatherMap', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([20, 10], 2);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 18,
            attribution: '&copy; CARTO'
        }).addTo(map);

        markersGroup.addTo(map);
    }

    // Initialize Chart.js
    function initChart() {
        const ctx = document.getElementById('temperatureChart').getContext('2d');
        tempChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['00:00', '02:00', '04:00', '06:00', '08:00', '10:00'],
                datasets: [{
                    label: 'Suhu (°C)',
                    data: [25, 24, 24, 26, 28, 30],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.15)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { font: { size: 10 } } },
                    y: { ticks: { font: { size: 10 } } }
                }
            }
        });
    }

    initMap();
    initChart();

    // Fetch Weather Data for Single Country or All
    function fetchSingleCountryWeather(countryId) {
        document.getElementById('weatherLoadingSpinner').classList.remove('d-none');
        document.getElementById('activeWeatherContent').classList.add('opacity-50');
        document.getElementById('weatherErrorAlert').classList.add('d-none');

        fetch(`{{ url('/api/weather/data') }}?country_id=${countryId}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('weatherLoadingSpinner').classList.add('d-none');
                document.getElementById('activeWeatherContent').classList.remove('opacity-50');

                if (res.success && res.data) {
                    updateActiveCountryUI(res.data);
                } else {
                    showError(res.message || 'Gagal memuat cuaca negara.');
                }
            })
            .catch(err => {
                document.getElementById('weatherLoadingSpinner').classList.add('d-none');
                document.getElementById('activeWeatherContent').classList.remove('opacity-50');
                showError('Koneksi gagal saat menghubungi server cuaca.');
            });
    }

    function fetchAllCountriesWeather() {
        document.getElementById('refreshSpinner').classList.add('fa-spin');
        document.getElementById('weatherErrorAlert').classList.add('d-none');

        fetch(`{{ url('/api/weather/data') }}`)
            .then(res => res.json())
            .then(res => {
                document.getElementById('refreshSpinner').classList.remove('fa-spin');
                if (res.success && res.data) {
                    if (Array.isArray(res.data)) {
                        allWeatherData = res.data;
                        updateSummaryCards(allWeatherData);
                        updateMapMarkers(allWeatherData);
                        renderAllCountriesGrid(allWeatherData);
                    } else {
                        updateActiveCountryUI(res.data);
                    }
                }
            })
            .catch(err => {
                document.getElementById('refreshSpinner').classList.remove('fa-spin');
                const loadingElem = document.getElementById('allCountriesLoading');
                if (loadingElem) loadingElem.classList.add('d-none');
                console.warn('Weather fetch notice:', err);
            });
    }

    // Update Main Weather UI Panel
    function updateActiveCountryUI(data) {
        selectedCountryId = data.country_id;
        document.getElementById('activeCountryName').innerText = data.country_name;
        document.getElementById('activeCountryRegion').innerText = `${data.region} (${data.country_code})`;
        document.getElementById('activeTemp').innerText = `${data.temperature}°C`;
        document.getElementById('activeCondition').innerText = data.condition_text;
        document.getElementById('activeWeatherIcon').className = `${data.weather_icon} fa-3x`;
        document.getElementById('activeWind').innerText = `${data.wind_speed} km/h`;
        document.getElementById('activeHumidity').innerText = `${data.humidity}%`;
        document.getElementById('activePrecip').innerText = `${data.precipitation} mm`;
        document.getElementById('activeUpdateTime').innerText = data.updated_at;
        document.getElementById('activeRiskText').innerText = data.risk_level;
        document.getElementById('activeRiskText').style.color = data.risk_color;
        document.getElementById('activeRiskNote').innerText = data.risk_note;

        const badge = document.getElementById('activeRiskBadge');
        badge.className = `badge ${data.risk_badge} px-3 py-1`;
        badge.innerText = data.risk_level;

        // Update Chart
        if (tempChart && data.hourly_labels && data.hourly_labels.length > 0) {
            tempChart.data.labels = data.hourly_labels;
            tempChart.data.datasets[0].data = data.hourly_temp;
            tempChart.update();
        }
    }

    // Update Summary Statistic Cards
    function updateSummaryCards(dataList) {
        if (!dataList || dataList.length === 0) return;

        let totalTemp = 0;
        let highRiskCount = 0;
        let maxWind = 0;

        dataList.forEach(d => {
            totalTemp += d.temperature;
            if (d.risk_level === 'High Risk') highRiskCount++;
            if (d.wind_speed > maxWind) maxWind = d.wind_speed;
        });

        const avgTemp = (totalTemp / dataList.length).toFixed(1);
        document.getElementById('statAvgTemp').innerText = `${avgTemp} °C`;
        document.getElementById('statHighRisk').innerText = `${highRiskCount} Badai/Alert`;
        document.getElementById('statMaxWind').innerText = `${maxWind} km/h`;
    }

    // Update Leaflet Map Markers
    function updateMapMarkers(dataList) {
        if (!map) return;
        markersGroup.clearLayers();

        dataList.forEach(d => {
            let markerColor = '#10b981';
            if (d.risk_level === 'High Risk') markerColor = '#ef4444';
            else if (d.risk_level === 'Medium Risk') markerColor = '#f59e0b';

            let circle = L.circleMarker([d.latitude, d.longitude], {
                radius: 9,
                color: markerColor,
                fillColor: markerColor,
                fillOpacity: 0.85,
                weight: 2
            }).addTo(markersGroup);

            circle.bindPopup(`
                <div style="font-family: 'Plus Jakarta Sans', sans-serif; padding: 4px; min-width: 180px;">
                    <h6 style="font-weight: 700; color: #0f172a; margin-bottom: 4px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">
                        <i class="fas fa-flag text-primary mr-1"></i> ${d.country_name}
                    </h6>
                    <div style="font-size: 0.85rem; color: #334155;">
                        <div class="mb-1"><strong>Suhu:</strong> ${d.temperature}°C</div>
                        <div class="mb-1"><strong>Cuaca:</strong> ${d.condition_text}</div>
                        <div class="mb-1"><strong>Angin:</strong> ${d.wind_speed} km/h</div>
                        <div class="mt-2">
                            <button onclick="window.selectCountryFromMap(${d.country_id})" class="btn btn-xs btn-primary btn-block text-white" style="font-size:0.75rem;">
                                Lihat Detail Cuaca
                            </button>
                        </div>
                    </div>
                </div>
            `);

            circle.on('click', function () {
                fetchSingleCountryWeather(d.country_id);
            });
        });
    }

    window.selectCountryFromMap = function (cId) {
        fetchSingleCountryWeather(cId);
    };

    // Render Grid Cards for "SEMUA Negara"
    function renderAllCountriesGrid(dataList) {
        const loadingElem = document.getElementById('allCountriesLoading');
        if (loadingElem) loadingElem.classList.add('d-none');

        const grid = document.getElementById('allCountriesGrid');
        const search = document.getElementById('searchInput').value.toLowerCase();
        const region = document.getElementById('regionFilter').value;
        const risk = document.getElementById('riskFilter').value;

        const filtered = dataList.filter(d => {
            const matchSearch = d.country_name.toLowerCase().includes(search) || d.country_code.toLowerCase().includes(search);
            const matchRegion = !region || d.region === region;
            const matchRisk = !risk || d.risk_level === risk;
            return matchSearch && matchRegion && matchRisk;
        });

        document.getElementById('allCountriesBadge').innerText = `${filtered.length} Negara`;

        if (filtered.length === 0) {
            grid.innerHTML = `
                <div class="col-12 text-center py-5 text-muted">
                    <i class="fas fa-search-minus fa-3x mb-3 text-muted opacity-50"></i>
                    <h5 class="font-weight-bold">Tidak Ada Data Cuaca yang Cocok</h5>
                    <p class="mb-0">Coba ubah kata kunci pencarian atau filter wilayah Anda.</p>
                </div>
            `;
            return;
        }

        grid.innerHTML = filtered.map(d => `
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card weather-card border shadow-sm h-100 p-3" style="border-radius: var(--radius-md);">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="font-weight-bold text-dark" style="font-size: 1.05rem;">
                            <i class="fas fa-flag text-primary mr-1"></i> ${d.country_name}
                        </span>
                        <span class="badge ${d.risk_badge}">${d.risk_level}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <div class="h2 font-weight-bold text-primary mb-0">${d.temperature}°C</div>
                            <small class="text-muted font-weight-bold">${d.condition_text}</small>
                        </div>
                        <div>
                            <i class="${d.weather_icon} fa-2x"></i>
                        </div>
                    </div>
                    <div class="row text-center border-top pt-2" style="font-size:0.78rem;">
                        <div class="col-4 border-right">
                            <span class="text-muted d-block">Angin</span>
                            <strong class="text-dark">${d.wind_speed}km/h</strong>
                        </div>
                        <div class="col-4 border-right">
                            <span class="text-muted d-block">Lembab</span>
                            <strong class="text-dark">${d.humidity}%</strong>
                        </div>
                        <div class="col-4">
                            <span class="text-muted d-block">Hujan</span>
                            <strong class="text-dark">${d.precipitation}mm</strong>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function showError(msg) {
        document.getElementById('weatherErrorMessage').innerText = msg;
        document.getElementById('weatherErrorAlert').classList.remove('d-none');
    }

    // Toggle View Modes
    document.getElementById('btnViewSingle').addEventListener('click', function () {
        this.classList.add('btn-primary', 'active');
        this.classList.remove('btn-outline-primary');
        document.getElementById('btnViewAll').classList.remove('btn-primary', 'active');
        document.getElementById('btnViewAll').classList.add('btn-outline-primary');

        document.getElementById('singleCountryView').classList.remove('d-none');
        document.getElementById('allCountriesView').classList.add('d-none');
        if (map) map.invalidateSize();
    });

    document.getElementById('btnViewAll').addEventListener('click', function () {
        this.classList.add('btn-primary', 'active');
        this.classList.remove('btn-outline-primary');
        document.getElementById('btnViewSingle').classList.remove('btn-primary', 'active');
        document.getElementById('btnViewSingle').classList.add('btn-outline-primary');

        document.getElementById('singleCountryView').classList.add('d-none');
        document.getElementById('allCountriesView').classList.remove('d-none');
    });

    // Refresh & Filter Events
    document.getElementById('btnRefreshWeather').addEventListener('click', function () {
        fetchAllCountriesWeather();
        if (selectedCountryId) fetchSingleCountryWeather(selectedCountryId);
    });

    document.getElementById('searchInput').addEventListener('input', function () {
        renderAllCountriesGrid(allWeatherData);
    });

    document.getElementById('regionFilter').addEventListener('change', function () {
        renderAllCountriesGrid(allWeatherData);
    });

    document.getElementById('riskFilter').addEventListener('change', function () {
        renderAllCountriesGrid(allWeatherData);
    });

    // Initial Load
    fetchAllCountriesWeather();
    if (selectedCountryId) fetchSingleCountryWeather(selectedCountryId);
});
</script>
@stop