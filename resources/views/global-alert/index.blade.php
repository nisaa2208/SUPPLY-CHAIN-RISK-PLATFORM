@extends('adminlte::page')

@section('title','Global Alert')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-exclamation-triangle text-danger mr-2"></i>
            Global Supply Chain Alert Center
        </h1>
        <div class="text-muted d-flex align-items-center" style="font-size: 0.88rem;">
            <span class="live-dot mr-2"></span> Automated Incident Tracking & Early Warning Risk Notification System
        </div>
    </div>
    <div>
        <span class="badge badge-danger px-3 py-2 shadow-sm" style="font-size:0.85rem;">
            <i class="fas fa-bell-exclamation mr-1"></i> Active Incident Monitor
        </span>
    </div>
</div>
@stop

@section('content')

<div class="row">

    <div class="col-md-3">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ $totalAlert }}</h3>

                <p>Total Alert</p>

            </div>

            <div class="icon">

                <i class="fas fa-bell"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>{{ $totalCountryAlert }}</h3>

                <p>Country Alert</p>

            </div>

            <div class="icon">

                <i class="fas fa-globe"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-info">

            <div class="inner">

                <h3>{{ $totalSupplierAlert }}</h3>

                <p>Supplier Alert</p>

            </div>

            <div class="icon">

                <i class="fas fa-truck"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>{{ $totalProductAlert }}</h3>

                <p>Product Alert</p>

            </div>

            <div class="icon">

                <i class="fas fa-box"></i>

            </div>

        </div>

    </div>

</div>

<div class="card card-outline card-danger">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-bolt"></i>

            Latest Critical Alert

        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <div class="alert alert-danger">

                    <h5>🌍 Country</h5>

                    @if($latestCountry)

                        <strong>{{ $latestCountry->name }}</strong>

                        <br>

                        Risk Score :

                        <strong>{{ $latestCountry->risk_score }}</strong>

                    @else

                        No Alert

                    @endif

                </div>

            </div>

            <div class="col-md-4">

                <div class="alert alert-warning">

                    <h5>🚚 Supplier</h5>

                    @if($latestSupplier)

                        <strong>{{ $latestSupplier->name }}</strong>

                        <br>

                        Risk Score :

                        <strong>{{ $latestSupplier->risk_score }}</strong>

                    @else

                        No Alert

                    @endif

                </div>

            </div>

            <div class="col-md-4">

                <div class="alert alert-info">

                    <h5>📦 Product</h5>

                    @if($latestProduct)

                        <strong>{{ $latestProduct->name }}</strong>

                        <br>

                        Risk Score :

                        <strong>{{ $latestProduct->risk_score }}</strong>

                    @else

                        No Alert

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card card-danger">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-globe"></i>

            High Risk Countries

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Country</th>

                    <th>Capital</th>

                    <th>Region</th>

                    <th>Risk Level</th>

                    <th>Risk Score</th>

                </tr>

            </thead>

            <tbody>

                @forelse($countries as $country)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $country->name }}</td>

                    <td>{{ $country->capital }}</td>

                    <td>{{ $country->region }}</td>

                    <td>

                        <span class="badge badge-danger">

                            {{ $country->risk_level }}

                        </span>

                    </td>

                    <td>

                        <strong>{{ $country->risk_score }}</strong>

                        @if($country->risk_score >= 90)

                            <span class="badge badge-danger">

                                Critical

                            </span>

                        @elseif($country->risk_score >=80)

                            <span class="badge badge-warning">

                                Warning

                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        No High Risk Country

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="card card-warning">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-truck"></i>

            High Risk Suppliers

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Supplier</th>

                    <th>Risk Score</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($suppliers as $supplier)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $supplier->name }}</td>

                    <td>

                        <strong>{{ $supplier->risk_score }}</strong>

                    </td>

                    <td>

                        @if($supplier->risk_score >= 90)

                            <span class="badge badge-danger">

                                Critical

                            </span>

                        @elseif($supplier->risk_score >= 80)

                            <span class="badge badge-warning">

                                Warning

                            </span>

                        @else

                            <span class="badge badge-success">

                                Safe

                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No High Risk Supplier

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



<div class="card card-info">

    <div class="card-header">

        <h3 class="card-title">

            <i class="fas fa-box"></i>

            High Risk Products

        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Product</th>

                    <th>Risk Score</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $product->name }}</td>

                    <td>

                        <strong>{{ $product->risk_score }}</strong>

                    </td>

                    <td>

                        @if($product->risk_score >= 90)

                            <span class="badge badge-danger">

                                Critical

                            </span>

                        @elseif($product->risk_score >= 80)

                            <span class="badge badge-warning">

                                Warning

                            </span>

                        @else

                            <span class="badge badge-success">

                                Safe

                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No High Risk Product

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop