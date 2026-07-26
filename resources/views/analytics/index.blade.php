@extends('adminlte::page')

@section('title', 'Analytics Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-chart-bar text-primary"></i>
        Supply Chain Analytics Dashboard
    </h1>
</div>
@stop

@section('content')

<div class="row">

    <div class="col-md-4">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countryCount }}</h3>
                <p>Total Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $supplierCount }}</h3>
                <p>Total Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $productCount }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary">
                <h3 class="card-title">
                    Master Data Comparison
                </h3>
            </div>
            <div class="card-body">
                <canvas id="masterChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-danger">
                <h3 class="card-title">
                    Risk Distribution
                </h3>
            </div>
            <div class="card-body">
                <canvas id="riskChart" height="120"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-success">
                <h3 class="card-title">
                    Risk Summary
                </h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4">
                        <h4 class="text-success">{{ $lowRisk }}</h4>
                        <small>Low Risk</small>
                    </div>
                    <div class="col-md-4">
                        <h4 class="text-warning">{{ $mediumRisk }}</h4>
                        <small>Medium Risk</small>
                    </div>
                    <div class="col-md-4">
                        <h4 class="text-danger">{{ $highRisk }}</h4>
                        <small>High Risk</small>
                    </div>
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

    const masterChart = document.getElementById('masterChart');
    if (masterChart) {
        new Chart(masterChart, {
            type: 'bar',
            data: {
                labels: ['Countries', 'Suppliers', 'Products'],
                datasets: [{
                    label: 'Total Data',
                    data: [
                        {{ $countryCount }},
                        {{ $supplierCount }},
                        {{ $productCount }}
                    ],
                    backgroundColor: ['#17a2b8', '#28a745', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    const riskChart = document.getElementById('riskChart');
    if (riskChart) {
        new Chart(riskChart, {
            type: 'pie',
            data: {
                labels: ['Low Risk', 'Medium Risk', 'High Risk'],
                datasets: [{
                    data: [
                        {{ $lowRisk }},
                        {{ $mediumRisk }},
                        {{ $highRisk }}
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545']
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