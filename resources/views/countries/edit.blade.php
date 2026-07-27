@extends('adminlte::page')

@section('title', 'Edit Country')

@section('content_header')
<h1>Edit Country</h1>
@stop

@section('content')

<div class="card card-warning">

    <div class="card-header">
        <h3 class="card-title">Edit Country Information</h3>
    </div>

    <form action="{{ route('countries.update', $country->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Name</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name',$country->name) }}"
                               required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Country Code</label>
                        <input type="text"
                               name="code"
                               class="form-control"
                               value="{{ old('code',$country->code) }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Region</label>
                        <input type="text"
                               name="region"
                               class="form-control"
                               value="{{ old('region',$country->region) }}"
                               required>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Risk Level</label>

                        <select name="risk_level" class="form-control">

                            <option value="Low"
                            {{ $country->risk_level=='Low'?'selected':'' }}>
                                Low
                            </option>

                            <option value="Medium"
                            {{ $country->risk_level=='Medium'?'selected':'' }}>
                                Medium
                            </option>

                            <option value="High"
                            {{ $country->risk_level=='High'?'selected':'' }}>
                                High
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Risk Score</label>
                        <input type="number"
                               name="risk_score"
                               class="form-control"
                               value="{{ old('risk_score',$country->risk_score) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Trade Index</label>
                        <input type="number"
                               name="trade_index"
                               class="form-control"
                               value="{{ old('trade_index',$country->trade_index) }}">
                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Shipping Status</label>

                        <select name="shipping_status" class="form-control">

                            <option value="Normal"
                            {{ $country->shipping_status=='Normal'?'selected':'' }}>
                                Normal
                            </option>

                            <option value="Delayed"
                            {{ $country->shipping_status=='Delayed'?'selected':'' }}>
                                Delayed
                            </option>

                            <option value="Critical"
                            {{ $country->shipping_status=='Critical'?'selected':'' }}>
                                Critical
                            </option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Supply Status</label>

                        <select name="supply_status" class="form-control">

                            <option value="Normal"
                            {{ $country->supply_status=='Normal'?'selected':'' }}>
                                Normal
                            </option>

                            <option value="Limited"
                            {{ $country->supply_status=='Limited'?'selected':'' }}>
                                Limited
                            </option>

                            <option value="Disrupted"
                            {{ $country->supply_status=='Disrupted'?'selected':'' }}>
                                Disrupted
                            </option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Latitude</label>
                        <input type="text"
                               name="latitude"
                               class="form-control"
                               value="{{ old('latitude',$country->latitude) }}">
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label>Longitude</label>
                        <input type="text"
                               name="longitude"
                               class="form-control"
                               value="{{ old('longitude',$country->longitude) }}">
                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-warning">
                Update Country
            </button>

            <a href="{{ route('countries.index') }}"
               class="btn btn-secondary">
                Back
            </a>

        </div>

    </form>

</div>

@stop