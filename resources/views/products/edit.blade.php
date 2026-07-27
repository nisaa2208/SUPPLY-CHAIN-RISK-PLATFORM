@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-edit text-warning"></i>
        Edit Product
    </h1>

    <a href="{{ route('products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <h5>
        <i class="fas fa-exclamation-triangle"></i>
        Validation Error
    </h5>

    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-warning shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box-open"></i>
            Update Product Information
        </h3>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Country</label>
                        <select name="country_id" class="form-control" required>
                            <option value="">-- Select Country --</option>

                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id', $product->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supplier</label>
                        <select name="supplier_id" class="form-control" required>
                            <option value="">-- Select Supplier --</option>

                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $product->name) }}"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <input
                            type="text"
                            name="category"
                            class="form-control"
                            value="{{ old('category', $product->category) }}"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Stock</label>
                        <input
                            type="number"
                            name="stock"
                            class="form-control"
                            min="0"
                            value="{{ old('stock', $product->stock) }}"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Shipping Status</label>
                        <select name="shipping_status" class="form-control" required>
                            <option value="">-- Select Shipping Status --</option>

                            <option value="Normal" {{ old('shipping_status', $product->shipping_status) == 'Normal' ? 'selected' : '' }}>
                                🚚 Normal
                            </option>

                            <option value="Delayed" {{ old('shipping_status', $product->shipping_status) == 'Delayed' ? 'selected' : '' }}>
                                ⏳ Delayed
                            </option>

                            <option value="Critical" {{ old('shipping_status', $product->shipping_status) == 'Critical' ? 'selected' : '' }}>
                                🚨 Critical
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Risk Score (1 - 100)</label>
                        <input
                            type="number"
                            name="risk_score"
                            class="form-control"
                            min="0"
                            max="100"
                            value="{{ old('risk_score', $product->risk_score) }}"
                            required>

                        <small class="text-muted">
                            Higher score indicates higher supply chain risk.
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i>
                Update Product
            </button>

            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </button>

            <a href="{{ route('products.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>

    </form>
</div>

@stop