@extends('adminlte::page')

@section('title','Global Alert')

@section('content_header')

<h1>
    <i class="fas fa-exclamation-triangle text-danger"></i>
    Global Supply Chain Alert Center
</h1>

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