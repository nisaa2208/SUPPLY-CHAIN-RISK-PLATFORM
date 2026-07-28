@extends('adminlte::page')

@section('title', 'Products Catalog')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-box text-warning mr-2"></i>
            Products Catalog
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Track Inventory Items, Category Risks & Shipping Logistics
        </div>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-warning shadow-sm">
        <i class="fas fa-plus-circle mr-1"></i> Add New Product
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-cubes text-warning mr-2"></i> Product Inventory Items
        </h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Country</th>
                        <th width="90" class="text-center">Stock</th>
                        <th width="120" class="text-center">Shipping</th>
                        <th width="120" class="text-center">Risk Level</th>
                        <th width="140" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td class="font-weight-bold text-muted text-center">
                            {{ ($products->currentPage()-1) * $products->perPage() + $loop->iteration }}
                        </td>

                        <td>
                            <a href="{{ route('products.show', $product->id) }}" class="font-weight-bold text-dark hover-primary">
                                <i class="fas fa-box-open text-muted mr-2"></i>{{ $product->name }}
                            </a>
                        </td>

                        <td>
                            <span class="badge badge-light border text-dark">{{ $product->category }}</span>
                        </td>

                        <td>
                            <span class="text-muted"><i class="fas fa-building text-muted mr-1"></i>{{ $product->supplier->name ?? '-' }}</span>
                        </td>

                        <td>
                            <span class="badge badge-light border">
                                <i class="fas fa-flag text-secondary mr-1"></i>{{ $product->country->name ?? '-' }}
                            </span>
                        </td>

                        <td class="text-center">
                            <span class="font-weight-bold text-dark">{{ number_format($product->stock) }}</span>
                        </td>

                        <td class="text-center">
                            @if($product->shipping_status == 'Normal')
                                <span class="badge badge-success">Normal</span>
                            @elseif($product->shipping_status == 'Delayed')
                                <span class="badge badge-warning">Delayed</span>
                            @else
                                <span class="badge badge-danger">Critical</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($product->risk_score >= 70)
                                <span class="badge badge-high">{{ $product->risk_score }}% High</span>
                            @elseif($product->risk_score >= 40)
                                <span class="badge badge-medium">{{ $product->risk_score }}% Med</span>
                            @else
                                <span class="badge badge-low">{{ $product->risk_score }}% Low</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete {{ $product->name }}?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-2x mb-2 d-block text-muted"></i>
                            No products registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($products->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
    @endif
</div>
@stop