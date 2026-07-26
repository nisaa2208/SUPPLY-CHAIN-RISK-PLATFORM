@extends('adminlte::page')

@section('title', 'Edit Country')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-edit text-warning"></i>
        Edit Country
    </h1>

    <a href="{{ route('countries.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <h5>
        <i class="fas fa-exclamation-triangle"></i>
        Validation Error
    </h5>

    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-warning shadow">

    <div class="card-header">

        <h3 class="card-title">
            <i class="fas fa-globe-asia"></i>
            Update Country Information
        </h3>

    </div>

    <form action="{{ route('countries.update', $country->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Name</label>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $country->name) }}"
                            required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Code</label>

                        <input
                            type="text"
                            name="code"
                            class="form-control"
                            value="{{ old('code', $country->code) }}"
                            required>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>ISO3</label>

                        <input
                            type="text"
                            name="iso3"
                            class="form-control"
                            value="{{ old('iso3', $country->iso3) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Capital City</label>

                        <input
                            type="text"
                            name="capital"
                            class="form-control"
                            value="{{ old('capital', $country->capital) }}"
                            required>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Region</label>

                        <input
                            type="text"
                            name="region"
                            class="form-control"
                            value="{{ old('region', $country->region) }}"
                            required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Sub Region</label>

                        <input
                            type="text"
                            name="sub_region"
                            class="form-control"
                            value="{{ old('sub_region', $country->sub_region) }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Currency</label>

                        <input
                            type="text"
                            name="currency"
                            class="form-control"
                            value="{{ old('currency', $country->currency) }}"
                            required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Population</label>

                        <input
                            type="number"
                            name="population"
                            class="form-control"
                            value="{{ old('population', $country->population) }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>GDP</label>

                        <input
                            type="number"
                            step="0.01"
                            name="gdp"
                            class="form-control"
                            value="{{ old('gdp', $country->gdp) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Risk Level</label>

                        <select name="risk_level" class="form-control" required>

                            <option value="Low"
                                {{ old('risk_level', $country->risk_level) == 'Low' ? 'selected' : '' }}>
                                🟢 Low Risk
                            </option>

                            <option value="Medium"
                                {{ old('risk_level', $country->risk_level) == 'Medium' ? 'selected' : '' }}>
                                🟡 Medium Risk
                            </option>

                            <option value="High"
                                {{ old('risk_level', $country->risk_level) == 'High' ? 'selected' : '' }}>
                                🔴 High Risk
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-4">

                    <div class="form-group">
                        <label>Risk Score</label>

                        <input
                            type="number"
                            name="risk_score"
                            class="form-control"
                            value="{{ old('risk_score', $country->risk_score) }}">
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label>Trade Index</label>

                        <input
                            type="number"
                            name="trade_index"
                            class="form-control"
                            value="{{ old('trade_index', $country->trade_index) }}">
                    </div>

                </div>

                <div class="col-md-4">

                    <div class="form-group">
                        <label>Supply Status</label>

                        <select name="supply_status" class="form-control">

                            <option value="Normal" {{ old('supply_status', $country->supply_status) == 'Normal' ? 'selected' : '' }}>
                                Normal
                            </option>

                            <option value="Limited" {{ old('supply_status', $country->supply_status) == 'Limited' ? 'selected' : '' }}>
                                Limited
                            </option>

                            <option value="Critical" {{ old('supply_status', $country->supply_status) == 'Critical' ? 'selected' : '' }}>
                                Critical
                            </option>

                        </select>
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Latitude</label>

                        <input
                            type="text"
                            name="latitude"
                            class="form-control"
                            value="{{ old('latitude', $country->latitude) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Longitude</label>

                        <input
                            type="text"
                            name="longitude"
                            class="form-control"
                            value="{{ old('longitude', $country->longitude) }}">
                    </div>

                </div>

            </div>

            <div class="form-group">
                <label>Shipping Status</label>

                <select name="shipping_status" class="form-control">

                    <option value="Open" {{ old('shipping_status', $country->shipping_status) == 'Open' ? 'selected' : '' }}>
                        Open
                    </option>

                    <option value="Busy" {{ old('shipping_status', $country->shipping_status) == 'Busy' ? 'selected' : '' }}>
                        Busy
                    </option>

                    <option value="Closed" {{ old('shipping_status', $country->shipping_status) == 'Closed' ? 'selected' : '' }}>
                        Closed
                    </option>

                </select>
            </div>

        </div>

        <div class="card-footer text-right">

            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i>
                Update Country
            </button>

            <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>

        </div>

    </form>

</div>

@stop