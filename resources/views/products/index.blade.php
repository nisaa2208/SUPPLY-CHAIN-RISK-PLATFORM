@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-box"></i> Products
    </h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Product
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}

    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="card shadow">

    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i> Product List
        </h3>
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">

            <thead class="thead-light text-center">

            <tr>
                <th width="60">No</th>
                <th>Country</th>
                <th>Supplier</th>
                <th>Product</th>
                <th>Category</th>
                <th width="90">Stock</th>
                <th width="120">Shipping</th>
                <th width="90">Risk</th>
                <th width="170">Action</th>
            </tr>

            </thead>

            <tbody>

            @forelse($products as $product)

            <tr>

                <td class="text-center">
                    {{ ($products->currentPage()-1) * $products->perPage() + $loop->iteration }}
                </td>

                <td>{{ $product->country->name ?? '-' }}</td>

                <td>{{ $product->supplier->name ?? '-' }}</td>

                <td>{{ $product->name }}</td>

                <td>{{ $product->category }}</td>

                <td class="text-center">
                    {{ $product->stock }}
                </td>

                <td class="text-center">

                    @if($product->shipping_status == 'Normal')

                        <span class="badge badge-success">
                            Normal
                        </span>

                    @elseif($product->shipping_status == 'Delayed')

                        <span class="badge badge-warning">
                            Delayed
                        </span>

                    @else

                        <span class="badge badge-danger">
                            Critical
                        </span>

                    @endif

                </td>

                <td class="text-center">

                    @if($product->risk_score >= 80)

                        <span class="badge badge-danger">
                            {{ $product->risk_score }}
                        </span>

                    @elseif($product->risk_score >= 50)

                        <span class="badge badge-warning">
                            {{ $product->risk_score }}
                        </span>

                    @else

                        <span class="badge badge-success">
                            {{ $product->risk_score }}
                        </span>

                    @endif

                </td>

                <td class="text-center">

                    <a href="{{ route('products.show', $product->id) }}"
                       class="btn btn-info btn-sm"
                       title="Detail">

                        <i class="fas fa-eye"></i>

                    </a>

                    <a href="{{ route('products.edit', $product->id) }}"
                       class="btn btn-warning btn-sm"
                       title="Edit">

                        <i class="fas fa-edit"></i>

                    </a>

                    <form action="{{ route('products.destroy', $product->id) }}"
                          method="POST"
                          style="display:inline">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?')">

                            <i class="fas fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center text-muted">
                    No product data available.
                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    @if($products->hasPages())
    <div class="card-footer clearfix">
        {{ $products->links() }}
    </div>
    @endif

</div>

@stop