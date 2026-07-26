@extends('adminlte::page')

@section('title', 'Suppliers Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-truck text-primary"></i>
        Suppliers Management
    </h1>

    <a href="{{ route('suppliers.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i>
        Add Supplier
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ number_format($suppliers->count()) }}</h3>
                <p>Total Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>
</div>

<div class="card card-primary shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i>
            Search & Filter
        </h3>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('suppliers.index') }}">
            <div class="row">
                <div class="col-md-5 mb-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Supplier..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-4 mb-2">
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
                    <div class="btn-group w-100">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                            Filter
                        </button>

                        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-light">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Supplier List
        </h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th width="60">No</th>
                    <th>Supplier</th>
                    <th>Country</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Supply Status</th>
                    <th>Risk Score</th>
                    <th width="170">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                    <tr>
                        <td>
                            {{ method_exists($suppliers, 'firstItem')
                                ? $suppliers->firstItem() + $loop->index
                                : $loop->iteration }}
                        </td>

                        <td>
                            <strong>{{ $supplier->name }}</strong>
                        </td>

                        <td>
                            🌍 {{ $supplier->country->name ?? '-' }}
                        </td>

                        <td>
                            {{ $supplier->email }}
                        </td>

                        <td>
                            {{ $supplier->phone }}
                        </td>

                        <td>
                            @if($supplier->supply_status == 'Stable')
                                <span class="badge badge-success">Stable</span>
                            @elseif($supplier->supply_status == 'Delayed')
                                <span class="badge badge-warning">Delayed</span>
                            @else
                                <span class="badge badge-danger">Critical</span>
                            @endif
                        </td>

                        <td>
                            @if($supplier->risk_score <= 30)
                                <span class="badge badge-success">{{ $supplier->risk_score }}</span>
                            @elseif($supplier->risk_score <= 70)
                                <span class="badge badge-warning">{{ $supplier->risk_score }}</span>
                            @else
                                <span class="badge badge-danger">{{ $supplier->risk_score }}</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('suppliers.show', $supplier->id) }}"
                               class="btn btn-info btn-sm"
                               title="View">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                               class="btn btn-warning btn-sm"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                  method="POST"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm"
                                    title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this supplier?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            <i class="fas fa-info-circle"></i>
                            No supplier data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($suppliers, 'links'))
    <div class="card-footer clearfix">
        {{ $suppliers->links() }}
    </div>
    @endif
</div>

@stop