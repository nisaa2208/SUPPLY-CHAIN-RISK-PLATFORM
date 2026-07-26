@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-chart-bar text-primary"></i>
        Reports Dashboard
    </h1>

    <div>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i>
            Print Report
        </button>

        <a href="{{ route('export.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i>
            Export PDF
        </a>

        <a href="{{ route('export.excel') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i>
            Export Excel
        </a>
    </div>
</div>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3 col-6">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ $totalCountries }}</h3>
                <p>Total Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success shadow">
            <div class="inner">
                <h3>{{ $totalSuppliers }}</h3>
                <p>Total Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning shadow">
            <div class="inner">
                <h3>{{ $totalProducts }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box-open"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger shadow">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Total Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

</div>

<div class="card shadow">

    <div class="card-header bg-primary">
        <h3 class="card-title">
            <i class="fas fa-exclamation-triangle"></i>
            High Risk Summary
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="bg-light">
                <tr>
                    <th width="70%">Category</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>
                        <i class="fas fa-globe text-danger"></i>
                        High Risk Countries
                    </td>
                    <td>
                        <span class="badge badge-danger">
                            {{ $highRiskCountries }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <i class="fas fa-truck text-warning"></i>
                        High Risk Suppliers
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            {{ $highRiskSuppliers }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <i class="fas fa-box-open text-info"></i>
                        High Risk Products
                    </td>
                    <td>
                        <span class="badge badge-info">
                            {{ $highRiskProducts }}
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

<div class="card shadow">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-chart-pie"></i>
            System Summary
        </h3>
    </div>

    <div class="card-body">

        <div class="row text-center">

            <div class="col-md-3">
                <h2 class="text-info">{{ $totalCountries }}</h2>
                <p>Countries</p>
            </div>

            <div class="col-md-3">
                <h2 class="text-success">{{ $totalSuppliers }}</h2>
                <p>Suppliers</p>
            </div>

            <div class="col-md-3">
                <h2 class="text-warning">{{ $totalProducts }}</h2>
                <p>Products</p>
            </div>

            <div class="col-md-3">
                <h2 class="text-danger">{{ $totalUsers }}</h2>
                <p>Users</p>
            </div>

        </div>

    </div>

</div>

@stop