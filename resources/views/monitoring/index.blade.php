@extends('adminlte::page')

@section('title','Supply Chain Monitoring')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-chart-area text-primary mr-2"></i>
            Supply Chain Monitoring
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Real-Time Tracking of Global Risk Indexes & Supplier Status
        </div>
    </div>
    <div>
        <span class="badge badge-info px-3 py-2" style="font-size: 0.85rem;">
            <i class="fas fa-satellite mr-1"></i> Live Satellite Feed
        </span>
    </div>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-danger shadow-sm">
            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $mediumRisk }}</h3>
                <p>Medium Risk Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $lowRisk }}</h3>
                <p>Low Risk Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-shipping-fast text-primary mr-2"></i>
                    Shipping Status Overview
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <tbody>
                        <tr>
                            <td class="font-weight-bold">
                                <i class="fas fa-check-circle text-success mr-2"></i> Normal Operations
                            </td>
                            <td class="text-right">
                                <span class="badge badge-success font-weight-bold">{{ $normalShipping }} Shipments</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">
                                <i class="fas fa-clock text-warning mr-2"></i> Delayed Shipments
                            </td>
                            <td class="text-right">
                                <span class="badge badge-warning font-weight-bold">{{ $delayedShipping }} Shipments</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">
                                <i class="fas fa-exclamation-circle text-danger mr-2"></i> Critical Alerts
                            </td>
                            <td class="text-right">
                                <span class="badge badge-danger font-weight-bold">{{ $criticalShipping }} Shipments</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h3 class="card-title font-weight-bold text-dark">
                    <i class="fas fa-industry text-success mr-2"></i>
                    Recent Suppliers Registered
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Supplier Name</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($suppliers as $supplier)
                            <tr>
                                <td class="font-weight-bold text-dark">
                                    <i class="fas fa-building text-muted mr-2"></i>{{ $supplier->name }}
                                </td>
                                <td>
                                    <span class="badge badge-light border">
                                        <i class="fas fa-flag text-secondary mr-1"></i>{{ optional($supplier->country)->name ?? 'Global' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3">No suppliers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark">
            <i class="fas fa-globe-americas text-indigo mr-2"></i>
            Monitored Countries Status
        </h3>
        <a href="{{ route('countries.index') }}" class="btn btn-sm btn-outline-primary">
            View All Countries <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Country</th>
                        <th>Region</th>
                        <th>Risk Score</th>
                        <th>Risk Level</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td class="font-weight-bold text-dark">{{ $country->name }}</td>
                        <td><span class="text-muted">{{ $country->region }}</span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold mr-2">{{ $country->risk_score }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px; border-radius: 4px;">
                                    <div class="progress-bar {{ $country->risk_score >= 70 ? 'bg-danger' : ($country->risk_score >= 40 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $country->risk_score }}%;"></div>
                                </div>
                            </div>
                        </td>
                        <td>{!! $country->risk_badge !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">No countries monitored</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop