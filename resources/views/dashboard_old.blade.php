@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>
    <i class="fas fa-globe-asia text-primary"></i>
    Global Supply Chain Risk Intelligence Platform
</h1>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countryCount }}</h3>
                <p>Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $supplierCount }}</h3>
                <p>Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $productCount }}</h3>
                <p>Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-bolt"></i>
                    Quick Access
                </h3>

            </div>

            <div class="card-body text-center">

                <a href="{{ route('countries.index') }}" class="btn btn-primary m-2">
                    <i class="fas fa-globe"></i><br>
                    Countries
                </a>

                <a href="{{ route('suppliers.index') }}" class="btn btn-success m-2">
                    <i class="fas fa-truck"></i><br>
                    Suppliers
                </a>

                <a href="{{ route('products.index') }}" class="btn btn-warning m-2">
                    <i class="fas fa-box"></i><br>
                    Products
                </a>

                <a href="{{ route('report.index') }}" class="btn btn-danger m-2">
                    <i class="fas fa-file-alt"></i><br>
                    Reports
                </a>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card card-info">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-cloud-sun"></i>
                    Weather & Exchange
                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th>Temperature</th>
                        <td>{{ $weather['temperature_2m'] ?? '-' }} °C</td>
                    </tr>

                    <tr>
                        <th>Humidity</th>
                        <td>{{ $weather['relative_humidity_2m'] ?? '-' }} %</td>
                    </tr>

                    <tr>
                        <th>Wind Speed</th>
                        <td>{{ $weather['wind_speed_10m'] ?? '-' }} km/h</td>
                    </tr>

                    <tr>
                        <th>USD → IDR</th>
                        <td>{{ number_format($usdToIdr,2) }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>
<div class="row">

    <div class="col-md-8">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i>
                    Dashboard Statistics
                </h3>

            </div>

            <div class="card-body">

                <canvas id="dashboardChart" height="120"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card card-danger">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i>
                    Risk Distribution
                </h3>

            </div>

            <div class="card-body">

                <canvas id="riskPieChart" height="250"></canvas>

            </div>

        </div>

    </div>

</div>


<div class="row">

    <div class="col-md-4">

        <div class="info-box bg-success">

            <span class="info-box-icon">
                <i class="fas fa-check"></i>
            </span>

            <div class="info-box-content">

                <span class="info-box-text">Low Risk</span>

                <span class="info-box-number">
                    {{ $lowRisk }}
                </span>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="info-box bg-warning">

            <span class="info-box-icon">
                <i class="fas fa-exclamation"></i>
            </span>

            <div class="info-box-content">

                <span class="info-box-text">Medium Risk</span>

                <span class="info-box-number">
                    {{ $mediumRisk }}
                </span>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="info-box bg-danger">

            <span class="info-box-icon">
                <i class="fas fa-radiation"></i>
            </span>

            <div class="info-box-content">

                <span class="info-box-text">High Risk</span>

                <span class="info-box-number">
                    {{ $highRisk }}
                </span>

            </div>

        </div>

    </div>

</div>
<div class="row">

    <div class="col-md-6">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-server"></i>
                    System Status
                </h3>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th>Application</th>
                        <td><span class="badge badge-success">Running</span></td>
                    </tr>

                    <tr>
                        <th>Database</th>
                        <td><span class="badge badge-success">Connected</span></td>
                    </tr>

                    <tr>
                        <th>Countries</th>
                        <td>{{ $countryCount }}</td>
                    </tr>

                    <tr>
                        <th>Suppliers</th>
                        <td>{{ $supplierCount }}</td>
                    </tr>

                    <tr>
                        <th>Products</th>
                        <td>{{ $productCount }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-history"></i>
                    Recent Activity
                </h3>

            </div>

            <div class="card-body">

                <ul class="list-group">

                    <li class="list-group-item d-flex justify-content-between">
                        Countries Data
                        <span class="badge badge-success">OK</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Suppliers Data
                        <span class="badge badge-success">OK</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Products Data
                        <span class="badge badge-success">OK</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Weather API
                        <span class="badge badge-info">Connected</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Exchange API
                        <span class="badge badge-warning">Connected</span>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>
<div class="row">

    <div class="col-md-12">

        <div class="card card-secondary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i>
                    About System
                </h3>

            </div>

            <div class="card-body">

                <p class="text-justify">

                    <strong>Global Supply Chain Risk Intelligence Platform</strong>
                    merupakan aplikasi berbasis Laravel yang digunakan
                    untuk memantau risiko rantai pasok global. Sistem ini
                    menyediakan informasi mengenai negara, supplier,
                    produk, kondisi cuaca, nilai tukar mata uang,
                    serta visualisasi data menggunakan grafik sehingga
                    memudahkan proses monitoring dan pengambilan keputusan.

                </p>

                <hr>

                <div class="row text-center">

                    <div class="col-md-3">
                        <h5>Framework</h5>
                        <span class="badge badge-primary">Laravel 9</span>
                    </div>

                    <div class="col-md-3">
                        <h5>Template</h5>
                        <span class="badge badge-success">AdminLTE</span>
                    </div>

                    <div class="col-md-3">
                        <h5>Database</h5>
                        <span class="badge badge-info">MySQL</span>
                    </div>

                    <div class="col-md-3">
                        <h5>Charts</h5>
                        <span class="badge badge-warning">Chart.js</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<hr>

<div class="text-center mb-3">

    <strong>Global Supply Chain Risk Intelligence Platform</strong><br>

    <small class="text-muted">
        Copyright © {{ date('Y') }} | Laravel 9 | AdminLTE
    </small>

</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =======================
    // BAR CHART
    // =======================

    const ctx = document.getElementById('dashboardChart');

    if (ctx) {

        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: [

                    'Countries',
                    'Suppliers',
                    'Products'

                ],

                datasets: [{

                    label: 'Total Data',

                    data: [

                        {{ $countryCount }},
                        {{ $supplierCount }},
                        {{ $productCount }}

                    ],

                    backgroundColor: [

                        '#17a2b8',
                        '#28a745',
                        '#ffc107'

                    ],

                    borderWidth: 1

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                scales: {

                    y: {

                        beginAtZero: true

                    }

                }

            }

        });

    }

    // =======================
    // PIE CHART
    // =======================

    const pie = document.getElementById('riskPieChart');

    if (pie) {

        new Chart(pie, {

            type: 'pie',

            data: {

                labels: [

                    'Low Risk',
                    'Medium Risk',
                    'High Risk'

                ],

                datasets: [{

                    data: [

                        {{ $lowRisk }},
                        {{ $mediumRisk }},
                        {{ $highRisk }}

                    ],

                    backgroundColor: [

                        '#28a745',
                        '#ffc107',
                        '#dc3545'

                    ]

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {

                        position: 'bottom'

                    }

                }

            }

        });

    }

});
</script>

@stop