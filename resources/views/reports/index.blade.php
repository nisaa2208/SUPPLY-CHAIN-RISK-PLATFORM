@extends('adminlte::page')

@section('title','Risk Reports & Data Export')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-file-alt text-primary mr-2"></i>
            Executive Risk Reports
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Exportable Supply Chain Intelligence & Risk Audit Documentation
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('export.pdf') }}" class="btn btn-danger shadow-sm" target="_blank">
            <i class="fas fa-file-pdf mr-1"></i> Export PDF Report
        </a>
        <a href="{{ route('export.excel') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-file-excel mr-1"></i> Export Excel Data
        </a>
    </div>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-info shadow-sm">
            <div class="inner">
                <h3>{{ $countries->count() }}</h3>
                <p>Monitored Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-success shadow-sm">
            <div class="inner">
                <h3>{{ $suppliers->count() }}</h3>
                <p>Audited Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="small-box bg-warning shadow-sm">
            <div class="inner">
                <h3>{{ $products->count() }}</h3>
                <p>Registered Items</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-table text-primary mr-2"></i> Country Vulnerability Summary Report
        </h3>
        <div class="text-muted" style="font-size: 0.85rem;">
            Showing {{ $countries->count() }} sovereign entities
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60" class="text-center">No</th>
                        <th>Country Name</th>
                        <th>Geographic Region</th>
                        <th width="180">Risk Score</th>
                        <th>Trade Index</th>
                        <th>Logistics Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($countries as $country)
                    <tr>
                        <td class="font-weight-bold text-muted text-center">{{ $loop->iteration }}</td>

                        <td class="font-weight-bold text-dark">
                            <i class="fas fa-flag text-muted mr-2"></i>{{ $country->name }}
                        </td>

                        <td><span class="text-muted">{{ $country->region }}</span></td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold mr-2" style="width: 38px;">{{ $country->risk_score }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px; border-radius: 4px;">
                                    <div class="progress-bar {{ $country->risk_score >= 70 ? 'bg-danger' : ($country->risk_score >= 40 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $country->risk_score }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="font-weight-bold text-dark">{{ $country->trade_index }}</span>
                        </td>

                        <td>
                            @if($country->shipping_status == 'Critical')
                                <span class="badge badge-danger">Critical Disruptions</span>
                            @elseif($country->shipping_status == 'Delayed')
                                <span class="badge badge-warning">Port Delays</span>
                            @else
                                <span class="badge badge-success">Smooth Operations</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">No countries to display in report.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop