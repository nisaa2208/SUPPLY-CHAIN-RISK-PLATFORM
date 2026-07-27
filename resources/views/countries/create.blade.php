@extends('adminlte::page')

@section('title', 'Add Country')

@section('content_header')
<h1>Add New Country</h1>
@stop

@section('content')

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Country Information</h3>
    </div>

    <form action="{{ route('countries.store') }}" method="POST">

        @csrf

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Code</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Region</label>
                        <input type="text" name="region" class="form-control" value="{{ old('region') }}" required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Risk Level</label>

                        <select name="risk_level" class="form-control">

                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Risk Score</label>
                        <input type="number" name="risk_score" class="form-control" value="{{ old('risk_score',0) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Trade Index</label>
                        <input type="number" name="trade_index" class="form-control" value="{{ old('trade_index',0) }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Shipping Status</label>

                        <select name="shipping_status" class="form-control">

                            <option value="Normal">Normal</option>
                            <option value="Delayed">Delayed</option>
                            <option value="Critical">Critical</option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Supply Status</label>

                        <select name="supply_status" class="form-control">

                            <option value="Normal">Normal</option>
                            <option value="Limited">Limited</option>
                            <option value="Disrupted">Disrupted</option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control" value="{{ old('latitude') }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control" value="{{ old('longitude') }}">
                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-success">
                Save Country
            </button>

            <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                Back
            </a>

        </div>

    </form>

</div>

@stop