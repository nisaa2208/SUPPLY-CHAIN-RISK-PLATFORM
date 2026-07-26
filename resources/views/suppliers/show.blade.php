@extends('adminlte::page')

@section('title', 'Supplier Details')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-truck text-info"></i>
        Supplier Details
    </h1>

    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

<div class="card card-info shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-industry"></i>
            {{ $supplier->name }}
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Supplier Name</th>
                        <td>{{ $supplier->name }}</td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td>{{ $supplier->country->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Email</th>
                        <td>{{ $supplier->email }}</td>
                    </tr>

                    <tr>
                        <th>Phone</th>
                        <td>{{ $supplier->phone }}</td>
                    </tr>

                    <tr>
                        <th>Address</th>
                        <td>{{ $supplier->address }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Supply Status</th>
                        <td>
                            @if($supplier->supply_status == 'Stable')
                                <span class="badge badge-success">🟢 Stable</span>
                            @elseif($supplier->supply_status == 'Delayed')
                                <span class="badge badge-warning">🟡 Delayed</span>
                            @else
                                <span class="badge badge-danger">🔴 Critical</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Risk Score</th>
                        <td>
                            <strong>{{ $supplier->risk_score }}</strong> / 100
                        </td>
                    </tr>

                    <tr>
                        <th>Risk Category</th>
                        <td>
                            @if($supplier->risk_score <= 30)
                                <span class="badge badge-success">LOW RISK</span>
                            @elseif($supplier->risk_score <= 70)
                                <span class="badge badge-warning">MEDIUM RISK</span>
                            @else
                                <span class="badge badge-danger">HIGH RISK</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Global Alert</th>
                        <td>
                            @if($supplier->risk_score >= 80)
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    ACTIVE
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i>
                                    SAFE
                                </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>
                            {{ $supplier->created_at->format('d F Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>
                            {{ $supplier->updated_at->format('d F Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit Supplier
        </a>

        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
</div>

@stop