@extends('adminlte::page')

@section('title', 'Product Detail')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">

    <h1>
        <i class="fas fa-box-open text-primary"></i>
        Product Detail
    </h1>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>

</div>

@stop

@section('content')

<div class="card card-primary shadow">

    <div class="card-header">
        <h3 class="card-title">
            Product Information
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="220">Country</th>
                <td>{{ $product->country->name }}</td>
            </tr>

            <tr>
                <th>Supplier</th>
                <td>{{ $product->supplier->name }}</td>
            </tr>

            <tr>
                <th>Product Name</th>
                <td>{{ $product->name }}</td>
            </tr>

            <tr>
                <th>Category</th>
                <td>{{ $product->category }}</td>
            </tr>

            <tr>
                <th>Stock</th>
                <td>{{ $product->stock }}</td>
            </tr>

            <tr>
                <th>Shipping Status</th>
                <td>

                    @if($product->shipping_status=="Normal")

                        <span class="badge badge-success">
                            Normal
                        </span>

                    @elseif($product->shipping_status=="Delayed")

                        <span class="badge badge-warning">
                            Delayed
                        </span>

                    @else

                        <span class="badge badge-danger">
                            Critical
                        </span>

                    @endif

                </td>
            </tr>

            <tr>
                <th>Risk Score</th>
                <td>

                    {{ $product->risk_score }}

                    /100

                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $product->created_at->format('d M Y H:i') }}</td>
            </tr>

            <tr>
                <th>Updated At</th>
                <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
            </tr>

        </table>

    </div>

    <div class="card-footer">

        <a href="{{ route('products.edit',$product->id) }}"
           class="btn btn-warning">

            <i class="fas fa-edit"></i>

            Edit Product

        </a>

        <a href="{{ route('products.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>

</div>

@stop