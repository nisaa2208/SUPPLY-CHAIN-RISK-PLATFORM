@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-box-open text-info"></i>
        Product Details
    </h1>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

<div class="card card-info shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i>
            {{ $product->name }}
        </h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Product Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td>{{ $product->country->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Supplier</th>
                        <td>{{ $product->supplier->name ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Category</th>
                        <td>
                            <span class="badge badge-info">
                                {{ $product->category }}
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <th>Stock</th>
                        <td>
                            {{ number_format($product->stock) }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="35%">Shipping Status</th>
                        <td>
                            @if($product->shipping_status == 'Normal')
                                <span class="badge badge-success">🚚 Normal</span>
                            @elseif($product->shipping_status == 'Delayed')
                                <span class="badge badge-warning">⏳ Delayed</span>
                            @else
                                <span class="badge badge-danger">🚨 Disrupted</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Risk Score</th>
                        <td>
                            <strong>{{ $product->risk_score }}</strong> / 100
                        </td>
                    </tr>

                    <tr>
                        <th>Risk Category</th>
                        <td>
                            @if($product->risk_score <= 30)
                                <span class="badge badge-success">LOW RISK</span>
                            @elseif($product->risk_score <= 70)
                                <span class="badge badge-warning">MEDIUM RISK</span>
                            @else
                                <span class="badge badge-danger">HIGH RISK</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Global Alert</th>
                        <td>
                            @if($product->risk_score >= 80)
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
                            {{ $product->created_at->format('d F Y') }}
                        </td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>
                            {{ $product->updated_at->format('d F Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card-footer text-right">
        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i>
            Edit Product
        </a>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Back
        </a>
    </div>
</div>

@stop