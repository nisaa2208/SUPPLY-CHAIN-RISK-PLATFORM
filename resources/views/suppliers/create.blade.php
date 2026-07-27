@extends('adminlte::page')

@section('title', 'Add Supplier')

@section('content_header')
<h1>Add Supplier</h1>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-primary">

    <div class="card-header">
        <h3 class="card-title">Supplier Information</h3>
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

                                <option value="{{ $country->id }}"
                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>

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
                            required>

                    </div>

                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email') }}">

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Phone</label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone') }}">

                    </div>

                </div>

            </div>

            <div class="form-group">

                <label>Address</label>

                <textarea
                    name="address"
                    rows="3"
                    class="form-control">{{ old('address') }}</textarea>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Supply Status</label>

                        <select
                            name="supply_status"
                            class="form-control">

                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">

                        <label>Risk Score</label>

                        <input
                            type="number"
                            name="risk_score"
                            class="form-control"
                            min="0"
                            max="100"
                            value="{{ old('risk_score',0) }}">

                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <button class="btn btn-success">

                <i class="fas fa-save"></i>

                Save Supplier

            </button>

            <a href="{{ route('suppliers.index') }}"
               class="btn btn-secondary">

                Cancel

            </a>

        </div>

    </form>

</div>

@stop