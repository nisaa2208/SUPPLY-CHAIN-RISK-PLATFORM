@extends('adminlte::page')

@section('title', 'Products Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-box-open text-primary"></i>
        Products Management
    </h1>

    <a href="{{ route('products.create') }}" class="btn btn-success">
        <i class="fas fa-plus-circle"></i>
        Add Product
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span>&times;</span>
    </button>
</div>
@endif

<div class="row">
    <div class="col-lg-3">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ number_format($products->count()) }}</h3>
                <p>Total Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i>
            Search & Filter
        </h3>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Product..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <select name="country_id" class="form-control">
                        <option value="">All Countries</option>

                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <select name="supplier_id" class="form-control">
                        <option value="">All Suppliers</option>

                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <button class="btn btn-primary btn-block" type="submit">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Product List
        </h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Country</th>
                    <th>Supplier</th>
                    <th>Category</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Risk</th>
                    <th width="170">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            {{ method_exists($products, 'firstItem')
                                ? $products->firstItem() + $loop->index
                                : $loop->iteration }}
                        </td>

                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td>
                            {{ $product->country->name ?? '-' }}
                        </td>

                        <td>
                            {{ $product->supplier->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ $product->category }}
                            </span>
                        </td>

                        <td>
                            {{ number_format($product->stock) }}
                        </td>

                        <td>
                            @if($product->shipping_status == 'Normal')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i>
                                    Normal
                                </span>
                            @elseif($product->shipping_status == 'Delayed')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i>
                                    Delayed
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Disrupted
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($product->risk_score <= 30)
                                <span class="badge badge-success">
                                    {{ $product->risk_score }}
                                </span>
                            @elseif($product->risk_score <= 70)
                                <span class="badge badge-warning">
                                    {{ $product->risk_score }}
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    {{ $product->risk_score }}
                                </span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('products.show', $product->id) }}"
                               class="btn btn-info btn-sm"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('products.edit', $product->id) }}"
                               class="btn btn-warning btn-sm"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('products.destroy', $product->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i>
                            No product data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($products, 'links'))
    <div class="card-footer clearfix">
        {{ $products->links() }}
    </div>
    @endif
</div>

@stop