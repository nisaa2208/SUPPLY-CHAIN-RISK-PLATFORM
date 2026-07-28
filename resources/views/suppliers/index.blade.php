@extends('adminlte::page')

@section('title', 'Suppliers Directory')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-truck text-success mr-2"></i>
            Suppliers Management
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Manage Verified Global Suppliers & Supply Chain Vendors
        </div>
    </div>

    <a href="{{ route('suppliers.create') }}" class="btn btn-success shadow-sm">
        <i class="fas fa-plus-circle mr-1"></i> Add New Supplier
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
            <i class="fas fa-building text-success mr-2"></i> Active Supplier Network
        </h3>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th width="60">No</th>
                        <th>Supplier Name</th>
                        <th>Country</th>
                        <th>Email Contact</th>
                        <th>Phone</th>
                        <th>Supply Status</th>
                        <th width="160">Risk Score</th>
                        <th width="140" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td class="font-weight-bold text-muted">{{ $loop->iteration }}</td>

                        <td>
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="font-weight-bold text-dark hover-primary">
                                <i class="fas fa-industry text-muted mr-2"></i>{{ $supplier->name }}
                            </a>
                        </td>

                        <td>
                            <span class="badge badge-light border">
                                <i class="fas fa-flag text-secondary mr-1"></i>{{ optional($supplier->country)->name ?? 'Global' }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted"><i class="fas fa-envelope text-muted mr-1"></i>{{ $supplier->email }}</span>
                        </td>

                        <td>
                            <span class="text-muted"><i class="fas fa-phone text-muted mr-1"></i>{{ $supplier->phone }}</span>
                        </td>

                        <td>
                            @if($supplier->supply_status == "Active")
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <span class="font-weight-bold mr-2" style="width: 38px;">{{ $supplier->risk_score }}%</span>
                                <div class="progress flex-grow-1" style="height: 6px; border-radius: 4px;">
                                    <div class="progress-bar {{ $supplier->risk_score >= 70 ? 'bg-danger' : ($supplier->risk_score >= 40 ? 'bg-warning' : 'bg-success') }}" 
                                         style="width: {{ $supplier->risk_score }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete {{ $supplier->name }}?')" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-industry fa-2x mb-2 d-block text-muted"></i>
                            No suppliers registered yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($suppliers->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-center">
            {{ $suppliers->links() }}
        </div>
    </div>
    @endif
</div>
@stop