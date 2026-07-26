@extends('adminlte::page')

@section('title', 'Country Details')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <h1>
        <i class="fas fa-globe-asia text-primary"></i>
        Country Details
    </h1>

    <a href="{{ route('countries.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>

</div>

@stop


@section('content')

<div class="card card-primary shadow">

    <div class="card-header">

        <h3 class="mb-0">
            <i class="fas fa-flag"></i>
            {{ $country->name }}
        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <div class="card card-outline card-primary">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-info-circle"></i>
                            Country Information
                        </h3>

                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>
                                <th width="35%">Country Name</th>
                                <td>{{ $country->name }}</td>
                            </tr>

                            <tr>
                                <th>Country Code</th>
                                <td>{{ $country->code }}</td>
                            </tr>

                            <tr>
                                <th>Capital City</th>
                                <td>{{ $country->capital }}</td>
                            </tr>

                            <tr>
                                <th>Region</th>
                                <td>{{ $country->region }}</td>
                            </tr>

                            <tr>
                                <th>Currency</th>
                                <td>{{ $country->currency }}</td>
                            </tr>

                            <tr>
                                <th>Population</th>
                                <td>{{ number_format($country->population) }}</td>
                            </tr>

                        </table>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card card-outline card-danger">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Risk Information
                        </h3>

                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>

                                <th width="35%">Risk Level</th>

                                <td>

                                    @if($country->risk_level=="Low")

                                        <span class="badge badge-success">
                                            🟢 Low Risk
                                        </span>

                                    @elseif($country->risk_level=="Medium")

                                        <span class="badge badge-warning">
                                            🟡 Medium Risk
                                        </span>

                                    @else

                                        <span class="badge badge-danger">
                                            🔴 High Risk
                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr>
                                <th>Risk Score</th>
                                <td>{{ $country->risk_score ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Trade Index</th>
                                <td>{{ $country->trade_index ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Shipping Status</th>
                                <td>{{ $country->shipping_status ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Supply Status</th>
                                <td>{{ $country->supply_status ?? '-' }}</td>
                            </tr>

                        </table>

                        <br>

                        @if($country->risk_level=="Low")

                        <div class="alert alert-success">

                            <i class="fas fa-check-circle"></i>

                            This country is considered safe for supply chain activities.

                        </div>

                        @elseif($country->risk_level=="Medium")

                        <div class="alert alert-warning">

                            <i class="fas fa-exclamation-circle"></i>

                            This country should be monitored carefully.

                        </div>

                        @else

                        <div class="alert alert-danger">

                            <i class="fas fa-radiation"></i>

                            High Risk! Immediate monitoring is recommended.

                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <div class="row mt-3">

            <div class="col-md-6">

                <div class="small-box bg-info">

                    <div class="inner">

                        <h3>{{ $country->suppliers->count() }}</h3>

                        <p>Total Suppliers</p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-industry"></i>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="small-box bg-success">

                    <div class="inner">

                        <h3>{{ $country->products->count() }}</h3>

                        <p>Total Products</p>

                    </div>

                    <div class="icon">

                        <i class="fas fa-box-open"></i>

                    </div>

                </div>

            </div>

        </div>
                <div class="row">

            <div class="col-md-6">

                <div class="card card-outline card-info">

                    <div class="card-header">

                        <h3 class="card-title">
                            <i class="fas fa-industry"></i>
                            Supplier List
                        </h3>

                    </div>

                    <div class="card-body">

                        @if($country->suppliers->count())

                            <div class="list-group">

                                @foreach($country->suppliers as $supplier)

                                    <div class="list-group-item">

                                        <i class="fas fa-truck text-info mr-2"></i>

                                        {{ $supplier->name }}

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="alert alert-light mb-0">

                                <i class="fas fa-info-circle"></i>

                                Supplier data is not available.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card card-outline card-success">

                    <div class="card-header">

                        <h3 class="card-title">

                            <i class="fas fa-box-open"></i>

                            Product List

                        </h3>

                    </div>

                    <div class="card-body">

                        @if($country->products->count())

                            <div class="list-group">

                                @foreach($country->products as $product)

                                    <div class="list-group-item">

                                        <i class="fas fa-box text-success mr-2"></i>

                                        {{ $product->name }}

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="alert alert-light mb-0">

                                <i class="fas fa-info-circle"></i>

                                Product data is not available.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <div class="text-right">

            <a href="{{ route('countries.edit',$country->id) }}"
               class="btn btn-warning">

                <i class="fas fa-edit"></i>

                Edit Country

            </a>

            <a href="{{ route('countries.index') }}"
               class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>

                Back

            </a>

        </div>

    </div>

</div>

@stop