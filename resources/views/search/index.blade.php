@extends('adminlte::page')

@section('title', 'Global Platform Search')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-search text-primary mr-2"></i>
            Global System Search
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Unified Search Across Monitored Countries, Suppliers & Products
        </div>
    </div>
</div>
@stop

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <form action="{{ route('search') }}" method="GET">
            <div class="input-group input-group-lg">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-right-0" style="border-radius: var(--radius-md) 0 0 var(--radius-md);">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                </div>
                <input type="text" name="keyword" class="form-control border-left-0" placeholder="Search by country name, supplier, or product category..." value="{{ $keyword }}" style="border-radius: 0 var(--radius-md) var(--radius-md) 0;">
                <div class="input-group-append ml-2">
                    <button class="btn btn-primary px-4 shadow-sm" type="submit" style="border-radius: var(--radius-md) !important;">
                        <i class="fas fa-search mr-1"></i> Search Intelligence
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@if($keyword)
<div class="row">
    <!-- Countries Results -->
    <div class="col-md-4">
        <div class="card card-outline card-info shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-info mb-0">
                    <i class="fas fa-globe-americas mr-2"></i> Countries ({{ $countries->count() }})
                </h3>
            </div>
            <div class="card-body p-3">
                @forelse($countries as $country)
                    <div class="p-3 mb-2 rounded bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <a href="{{ route('countries.show', $country->id) }}" class="font-weight-bold text-dark hover-primary">
                                {{ $country->name }}
                            </a>
                            <span class="badge {{ $country->risk_level == 'High' ? 'badge-danger' : ($country->risk_level == 'Medium' ? 'badge-warning' : 'badge-success') }}">
                                {{ $country->risk_level }} Risk
                            </span>
                        </div>
                        <div class="text-muted" style="font-size: 0.82rem;">
                            Region: {{ $country->region }} | Risk Score: <strong>{{ $country->risk_score }}%</strong>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-globe fa-2x mb-2 d-block text-muted"></i>
                        No matching countries found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Suppliers Results -->
    <div class="col-md-4">
        <div class="card card-outline card-success shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-success mb-0">
                    <i class="fas fa-truck mr-2"></i> Suppliers ({{ $suppliers->count() }})
                </h3>
            </div>
            <div class="card-body p-3">
                @forelse($suppliers as $supplier)
                    <div class="p-3 mb-2 rounded bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="font-weight-bold text-dark hover-primary">
                                {{ $supplier->name }}
                            </a>
                            <span class="badge {{ $supplier->supply_status == 'Active' ? 'badge-success' : 'badge-danger' }}">
                                {{ $supplier->supply_status }}
                            </span>
                        </div>
                        <div class="text-muted" style="font-size: 0.82rem;">
                            Country: {{ optional($supplier->country)->name ?? 'Global' }} | Contact: {{ $supplier->email }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-industry fa-2x mb-2 d-block text-muted"></i>
                        No matching suppliers found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Products Results -->
    <div class="col-md-4">
        <div class="card card-outline card-warning shadow-sm h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-warning mb-0">
                    <i class="fas fa-box-open mr-2"></i> Products ({{ $products->count() }})
                </h3>
            </div>
            <div class="card-body p-3">
                @forelse($products as $product)
                    <div class="p-3 mb-2 rounded bg-light border">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <a href="{{ route('products.show', $product->id) }}" class="font-weight-bold text-dark hover-primary">
                                {{ $product->name }}
                            </a>
                            <span class="badge badge-light border">{{ $product->category }}</span>
                        </div>
                        <div class="text-muted" style="font-size: 0.82rem;">
                            Stock: {{ number_format($product->stock) }} | Shipping: <strong>{{ $product->shipping_status }}</strong>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-box fa-2x mb-2 d-block text-muted"></i>
                        No matching products found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endif

@stop