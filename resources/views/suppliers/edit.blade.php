@extends('adminlte::page')

@section('title', 'Edit Supplier')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-edit text-warning"></i>
        Edit Supplier
    </h1>

    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
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
            <i class="fas fa-industry"></i>
            Update Supplier Information
        </h3>
    </div>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
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
                                <option value="{{ $country->id }}"
                                    {{ old('country_id', $supplier->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supplier Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $supplier->name) }}"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $supplier->email) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone', $supplier->phone) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Supplier Address</label>
                <textarea
                    name="address"
                    rows="4"
                    class="form-control">{{ old('address', $supplier->address) }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supply Status</label>
                        <select name="supply_status" class="form-control" required>
                            <option value="">-- Select Supply Status --</option>

                            <option value="Active"
                                {{ old('supply_status', $supplier->supply_status) == 'Active' ? 'selected' : '' }}>
                                🟢 Active
                            </option>

                            <option value="Inactive"
                                {{ old('supply_status', $supplier->supply_status) == 'Inactive' ? 'selected' : '' }}>
                                🔴 Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Risk Score (1 - 100)</label>
                        <input
                            type="number"
                            name="risk_score"
                            class="form-control"
                            min="1"
                            max="100"
                            value="{{ old('risk_score', $supplier->risk_score) }}"
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
                Update Supplier
            </button>

            <button type="reset" class="btn btn-secondary">
                <i class="fas fa-redo"></i>
                Reset
            </button>

            <a href="{{ route('suppliers.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

@stop