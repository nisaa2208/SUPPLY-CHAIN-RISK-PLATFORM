@extends('adminlte::page')

@section('title', 'Add Supplier')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-truck text-success"></i>
        Add New Supplier
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

<div class="card card-success shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-industry"></i>
            Supplier Information
        </h3>
    </div>

    <form action="{{ route('suppliers.store') }}" method="POST">
        @csrf

        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Country</label>
                        <select name="country_id" class="form-control" required>
                            <option value="">-- Select Country --</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
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
                            value="{{ old('name') }}"
                            placeholder="Enter Supplier Name"
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
                            value="{{ old('email') }}"
                            placeholder="example@gmail.com"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Supplier Address</label>
                <textarea
                    name="address"
                    rows="4"
                    class="form-control"
                    placeholder="Enter Supplier Address"
                    required>{{ old('address') }}</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Supply Status</label>
                        <select name="supply_status" class="form-control" required>
                            <option value="">-- Select Supply Status --</option>

                            <option value="Stable" {{ old('supply_status') == 'Stable' ? 'selected' : '' }}>
                                🟢 Stable
                            </option>

                            <option value="Delayed" {{ old('supply_status') == 'Delayed' ? 'selected' : '' }}>
                                🟡 Delayed
                            </option>

                            <option value="Critical" {{ old('supply_status') == 'Critical' ? 'selected' : '' }}>
                                🔴 Critical
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
                            value="{{ old('risk_score') }}"
                            placeholder="Example: 85"
                            required>
                        <small class="text-muted">
                            Higher score indicates higher supply chain risk.
                        </small>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer text-right">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i>
                Save Supplier
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