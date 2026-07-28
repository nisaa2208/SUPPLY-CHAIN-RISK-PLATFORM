@extends('adminlte::page')

@section('title', 'Lokasi Pelabuhan & Rute Distribusi Maritim')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-anchor text-primary mr-2"></i>
            Lokasi Pelabuhan Dunia & Rute Maritim Global (GIS)
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Monitoring Pelabuhan Laut Interaktif, Tingkat Kepadatan, Status Operasional & Jalur Distribusi Logistik
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <button id="btnRefreshPorts" class="btn btn-primary btn-sm shadow-sm font-weight-bold">
            <i class="fas fa-sync-alt mr-1" id="refreshSpinner"></i> Refresh Data Pelabuhan
        </button>
    </div>
</div>
@stop

@section('css')
<!-- Leaflet CSS & JS in head to guarantee loading -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
#portMap {
    height: 480px;
    width: 100%;
    border-radius: var(--radius-md);
    border: 1px solid #cbd5e1;
    background: #e2e8f0;
}
.map-legend-box {
    position: absolute;
    bottom: 25px;
    right: 25px;
    background: rgba(255, 255, 255, 0.95);
    padding: 12px 16px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    font-size: 0.85rem;
    backdrop-filter: blur(4px);
}
.map-control-btn-group {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 1000;
}
.port-table-scroll-container {
    max-height: 500px;
    overflow-y: auto;
}
.port-table-scroll-container::-webkit-scrollbar {
    width: 6px;
}
.port-table-scroll-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
.table-sticky-header th {
    position: sticky;
    top: 0;
    background-color: #f8fafc;
    z-index: 2;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
</style>
@stop

@section('content')

<!-- Summary Metrics Analytics Row -->
<div class="row">
    <div class="col-md-3 mb-3">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3 id="statTotalPorts">{{ $totalPortsCount }}</h3>
                <p>Total Pelabuhan Dipantau</p>
            </div>
            <div class="icon">
                <i class="fas fa-anchor"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3 id="statLowRisk">{{ $lowRiskCount }}</h3>
                <p>Status Low Risk (Normal)</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3 id="statMediumRisk">{{ $mediumRiskCount }}</h3>
                <p>Status Medium Risk (Padat)</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3 id="statHighRisk">{{ $highRiskCount }}</h3>
                <p>Status High Risk (Sangat Padat)</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter Controls -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center">
            <div class="col-md-5 mb-2 mb-md-0">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" id="portSearchInput" class="form-control border-left-0" placeholder="Cari nama pelabuhan, kode, atau kota..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3 mb-2 mb-md-0">
                <select id="countryFilter" class="form-control custom-select">
                    <option value="">-- Semua Negara --</option>
                    @foreach($countries as $c)
                        <option value="{{ $c }}" {{ request('country') == $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 mb-2 mb-md-0">
                <select id="riskFilter" class="form-control custom-select">
                    <option value="">-- Semua Risiko --</option>
                    <option value="Low Risk">Low Risk (Hijau)</option>
                    <option value="Medium Risk">Medium Risk (Kuning)</option>
                    <option value="High Risk">High Risk (Merah)</option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="button" id="btnApplyFilter" class="btn btn-primary btn-block shadow-sm font-weight-bold">
                    <i class="fas fa-filter mr-1"></i> Filter Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Interactive GIS Map Section -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-map-marked-alt text-primary mr-2"></i> Peta Interaktif Pelabuhan Laut & Rute Maritim Global
        </h3>
        <span class="badge badge-primary px-3 py-1 font-weight-bold">
            OpenStreetMap GIS View
        </span>
    </div>

    <div class="card-body p-2 position-relative">
        <!-- Floating Map Controls -->
        <div class="map-control-btn-group d-flex gap-2">
            <button id="btnResetView" class="btn btn-light btn-sm shadow font-weight-bold border mr-2">
                <i class="fas fa-compress-arrows-alt mr-1"></i> Reset View
            </button>

            <button id="btnToggleRoutes" class="btn btn-indigo btn-sm shadow font-weight-bold text-white" style="background:#6366f1;">
                <i class="fas fa-route mr-1"></i> Toggle Rute Maritim
            </button>
        </div>

        <!-- Leaflet Map Canvas Container -->
        <div id="portMap"></div>

        <!-- Floating Map Legend Box -->
        <div class="map-legend-box">
            <div class="font-weight-bold mb-2 text-dark border-bottom pb-1"><i class="fas fa-info-circle mr-1"></i> Legenda Risiko Pelabuhan</div>
            <div class="d-flex align-items-center mb-1">
                <span class="d-inline-block rounded-circle mr-2" style="width:12px; height:12px; background:#10b981;"></span>
                <span>Low Risk (Kepadatan Normal)</span>
            </div>
            <div class="d-flex align-items-center mb-1">
                <span class="d-inline-block rounded-circle mr-2" style="width:12px; height:12px; background:#f59e0b;"></span>
                <span>Medium Risk (Kepadatan Padat)</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="d-inline-block rounded-circle mr-2" style="width:12px; height:12px; background:#ef4444;"></span>
                <span>High Risk (Kepadatan Sangat Padat)</span>
            </div>
        </div>
    </div>
</div>

<!-- Synchronized Port List Table Card -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-list-alt text-primary mr-2"></i> Direktori & Status Operasional Pelabuhan
        </h3>
        <span class="badge badge-primary px-3 py-1 font-weight-bold" id="tablePortCount">
            Total: {{ $ports->count() }} Pelabuhan
        </span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive port-table-scroll-container">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-sticky-header">
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Pelabuhan</th>
                        <th>Kode Port</th>
                        <th>Negara & Kota</th>
                        <th>Tipe Pelabuhan</th>
                        <th>Status Operasional</th>
                        <th>Tingkat Kepadatan</th>
                        <th>Tingkat Risiko Logistik</th>
                        <th width="120" class="text-center">Aksi Peta</th>
                    </tr>
                </thead>

                <tbody id="portsTableBody">
                    @forelse($ports as $port)
                    <tr>
                        <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <span class="font-weight-bold text-dark">
                                <i class="fas fa-anchor text-primary mr-2"></i>{{ $port->name }}
                            </span>
                        </td>
                        <td><span class="badge badge-light border font-weight-bold">{{ $port->port_code ?? '-' }}</span></td>
                        <td><span class="text-dark font-weight-bold">{{ $port->country }}</span> {{ $port->city ? '('.$port->city.')' : '' }}</td>
                        <td><small class="text-muted">{{ $port->port_type ?? 'Container Port' }}</small></td>
                        <td><span class="badge badge-success px-2">{{ $port->status ?? 'Active' }}</span></td>
                        <td><span class="font-weight-bold text-dark" style="font-size:0.88rem;">{{ $port->congestion_level ?? 'Normal' }}</span></td>
                        <td>
                            @if(($port->risk_level ?? '') == 'High Risk' || ($port->congestion_level ?? '') == 'Sangat Padat')
                                <span class="badge badge-danger font-weight-bold px-2 py-1">High Risk</span>
                            @elseif(($port->risk_level ?? '') == 'Medium Risk' || ($port->congestion_level ?? '') == 'Padat')
                                <span class="badge badge-warning font-weight-bold px-2 py-1">Medium Risk</span>
                            @else
                                <span class="badge badge-success font-weight-bold px-2 py-1">Low Risk</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-xs btn-outline-primary font-weight-bold btn-focus-port" data-id="{{ $port->id }}">
                                <i class="fas fa-search-location mr-1"></i> Fokus Peta
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="fas fa-anchor fa-3x mb-3 text-muted opacity-50"></i>
                            <h6 class="font-weight-bold">Pelabuhan Tidak Ditemukan</h6>
                            <p class="mb-0">Silakan ubah kata kunci pencarian atau filter negara Anda.</p>
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
<script>
(function() {
    var portsData = @json($ports);
    var routesData = @json($routes);
    var map = null;
    var markersGroup = null;
    var routesGroup = null;
    var showRoutes = true;
    var markersMap = {};

    function initPortMap() {
        var el = document.getElementById('portMap');
        if (!el || typeof L === 'undefined') return;

        try {
            map = L.map('portMap').setView([20, 15], 2.5);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            markersGroup = L.layerGroup().addTo(map);
            routesGroup = L.layerGroup().addTo(map);

            renderMarkers();
            renderRoutes();
            attachTableEvents();

            setTimeout(function() {
                if (map) map.invalidateSize();
            }, 300);
            setTimeout(function() {
                if (map) map.invalidateSize();
            }, 800);
        } catch(err) {
            console.error("Map error:", err);
        }
    }

    function renderMarkers() {
        if (!markersGroup || !Array.isArray(portsData)) return;
        markersGroup.clearLayers();
        markersMap = {};

        portsData.forEach(function(port) {
            var lat = parseFloat(port.latitude);
            var lng = parseFloat(port.longitude);

            if (isNaN(lat) || isNaN(lng)) return;

            var color = '#10b981';
            var badgeClass = 'badge-success';

            if (port.risk_level === 'High Risk' || port.congestion_level === 'Sangat Padat') {
                color = '#ef4444';
                badgeClass = 'badge-danger';
            } else if (port.risk_level === 'Medium Risk' || port.congestion_level === 'Padat') {
                color = '#f59e0b';
                badgeClass = 'badge-warning';
            }

            var marker = L.circleMarker([lat, lng], {
                radius: 8,
                fillColor: color,
                color: '#ffffff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.85
            });

            var popupContent = '<div style="min-width:220px;">' +
                '<h6 style="font-weight:700; margin-bottom:4px;"><i class="fas fa-anchor text-primary mr-1"></i> ' + (port.name || 'Pelabuhan') + '</h6>' +
                '<div style="font-size:0.85rem; color:#64748b; margin-bottom:6px;">' + (port.city ? port.city + ', ' : '') + '<b>' + (port.country || '') + '</b></div>' +
                '<div style="background:#f8fafc; padding:6px; border-radius:4px; font-size:0.8rem; margin-bottom:8px;">' +
                '<div><b>Tipe:</b> ' + (port.port_type || 'Container Port') + '</div>' +
                '<div><b>Kepadatan:</b> ' + (port.congestion_level || 'Normal') + '</div>' +
                '</div>' +
                '<span class="badge ' + badgeClass + ' font-weight-bold px-2 py-1">' + (port.risk_level || 'Low Risk') + '</span>' +
                '</div>';

            marker.bindPopup(popupContent);
            markersGroup.addLayer(marker);
            markersMap[port.id] = marker;
        });
    }

    function renderRoutes() {
        if (!routesGroup || !Array.isArray(routesData)) return;
        routesGroup.clearLayers();

        if (showRoutes) {
            routesData.forEach(function(route) {
                if (Array.isArray(route.coordinates)) {
                    var line = L.polyline(route.coordinates, {
                        color: route.color || '#3b82f6',
                        weight: 3,
                        opacity: 0.75,
                        dashArray: '6, 8'
                    });
                    line.bindTooltip(route.name || 'Rute Maritim', { sticky: true });
                    routesGroup.addLayer(line);
                }
            });
        }
    }

    function attachTableEvents() {
        var buttons = document.querySelectorAll('.btn-focus-port');
        buttons.forEach(function(btn) {
            btn.onclick = function() {
                var portId = this.getAttribute('data-id');
                var port = portsData.find(function(p) { return p.id == portId; });
                if (port && map) {
                    var lat = parseFloat(port.latitude);
                    var lng = parseFloat(port.longitude);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        map.flyTo([lat, lng], 9, { animate: true, duration: 1.0 });
                        if (markersMap[portId]) {
                            setTimeout(function() { markersMap[portId].openPopup(); }, 1000);
                        }
                        document.getElementById('portMap').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            };
        });
    }

    function fetchLivePorts() {
        var search = document.getElementById('portSearchInput').value;
        var country = document.getElementById('countryFilter').value;
        var risk = document.getElementById('riskFilter').value;
        var spinner = document.getElementById('refreshSpinner');

        if (spinner) spinner.classList.add('fa-spin');

        var params = new URLSearchParams({ search: search, country: country, risk_level: risk });

        fetch('{{ url("/api/ports/live") }}?' + params.toString())
            .then(function(res) { return res.json(); })
            .then(function(res) {
                if (spinner) spinner.classList.remove('fa-spin');
                if (res.success && Array.isArray(res.ports)) {
                    portsData = res.ports;
                    renderMarkers();
                    renderTable();
                    if (map) map.invalidateSize();
                }
            })
            .catch(function(err) {
                if (spinner) spinner.classList.remove('fa-spin');
            });
    }

    function renderTable() {
        var tbody = document.getElementById('portsTableBody');
        if (!tbody || !Array.isArray(portsData)) return;

        if (portsData.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" class="text-center text-muted py-5">' +
                '<i class="fas fa-anchor fa-3x mb-3 text-muted opacity-50 d-block"></i>' +
                '<h6 class="font-weight-bold">Pelabuhan Tidak Ditemukan dengan Filter Saat Ini</h6>' +
                '<p class="mb-3 text-muted">Silakan ubah kata kunci pencarian atau tekan tombol di bawah untuk mereset filter.</p>' +
                '<button type="button" id="btnResetPortFilters" class="btn btn-sm btn-primary font-weight-bold shadow-sm">' +
                '<i class="fas fa-sync-alt mr-1"></i> Reset Filter & Tampilkan Semua Pelabuhan</button>' +
                '</td></tr>';

            var btnResetTable = document.getElementById('btnResetPortFilters');
            if (btnResetTable) {
                btnResetTable.onclick = function() {
                    document.getElementById('portSearchInput').value = '';
                    document.getElementById('countryFilter').value = '';
                    document.getElementById('riskFilter').value = '';
                    fetchLivePorts();
                };
            }
            return;
        }

        var html = '';
        portsData.forEach(function(port, idx) {
            var riskBadge = (port.risk_level === 'High Risk') ? 'badge-danger' : ((port.risk_level === 'Medium Risk') ? 'badge-warning' : 'badge-success');
            html += '<tr>' +
                '<td class="text-center font-weight-bold text-muted">' + (idx + 1) + '</td>' +
                '<td><span class="font-weight-bold text-dark"><i class="fas fa-anchor text-primary mr-2"></i>' + port.name + '</span></td>' +
                '<td><span class="badge badge-light border font-weight-bold">' + (port.port_code || '-') + '</span></td>' +
                '<td><span class="text-dark font-weight-bold">' + port.country + '</span> ' + (port.city ? '(' + port.city + ')' : '') + '</td>' +
                '<td><small class="text-muted">' + (port.port_type || 'Container Port') + '</small></td>' +
                '<td><span class="badge badge-success px-2">' + (port.status || 'Active') + '</span></td>' +
                '<td><span class="font-weight-bold text-dark">' + (port.congestion_level || 'Normal') + '</span></td>' +
                '<td><span class="badge ' + riskBadge + ' font-weight-bold px-2 py-1">' + (port.risk_level || 'Low Risk') + '</span></td>' +
                '<td class="text-center"><button type="button" class="btn btn-xs btn-outline-primary font-weight-bold btn-focus-port" data-id="' + port.id + '"><i class="fas fa-search-location mr-1"></i> Fokus Peta</button></td>' +
                '</tr>';
        });

        tbody.innerHTML = html;
        attachTableEvents();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPortMap);
    } else {
        initPortMap();
    }

    window.onload = function() {
        if (map) map.invalidateSize();
    };

    var btnRefresh = document.getElementById('btnRefreshPorts');
    if (btnRefresh) btnRefresh.onclick = fetchLivePorts;

    var btnApply = document.getElementById('btnApplyFilter');
    if (btnApply) btnApply.onclick = fetchLivePorts;

    var countrySel = document.getElementById('countryFilter');
    if (countrySel) countrySel.onchange = fetchLivePorts;

    var riskSel = document.getElementById('riskFilter');
    if (riskSel) riskSel.onchange = fetchLivePorts;

    var btnReset = document.getElementById('btnResetView');
    if (btnReset) {
        btnReset.onclick = function() {
            if (map) {
                map.flyTo([20, 15], 2.5, { animate: true, duration: 1.0 });
                setTimeout(function() { map.invalidateSize(); }, 300);
            }
        };
    }

    var btnToggle = document.getElementById('btnToggleRoutes');
    if (btnToggle) {
        btnToggle.onclick = function() {
            showRoutes = !showRoutes;
            renderRoutes();
        };
    }
})();
</script>
@stop
