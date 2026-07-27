@extends('adminlte::page')

@section('title', 'Country Detail')

@section('content_header')
<h1>
    <i class="fas fa-globe-americas text-primary"></i>
    Country Detail
</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-8">

        <div class="card card-primary">

            <div class="card-header">
                <h3 class="card-title">{{ $country->name }}</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Country Name</th>
                        <td>{{ $country->name }}</td>
                    </tr>

                    <tr>
                        <th>Country Code</th>
                        <td>{{ $country->code ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Region</th>
                        <td>{{ $country->region }}</td>
                    </tr>

                    <tr>
                        <th>Risk Score</th>
                        <td>{{ $country->risk_score }}</td>
                    </tr>

                    <tr>
                        <th>Risk Level</th>
                        <td>
                            {!! $country->risk_badge !!}
                        </td>
                    </tr>

                    <tr>
                        <th>Trade Index</th>
                        <td>{{ $country->trade_index }}</td>
                    </tr>

                    <tr>
                        <th>Shipping Status</th>
                        <td>{{ $country->shipping_status }}</td>
                    </tr>

                    <tr>
                        <th>Supply Status</th>
                        <td>{{ $country->supply_status ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Latitude</th>
                        <td>{{ $country->latitude ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Longitude</th>
                        <td>{{ $country->longitude ?? '-' }}</td>
                    </tr>

                    <tr>
                        <th>Total Suppliers</th>
                        <td>{{ $country->suppliers()->count() }}</td>
                    </tr>

                    <tr>
                        <th>Total Products</th>
                        <td>{{ $country->products()->count() }}</td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $country->created_at->format('d M Y H:i') }}</td>
                    </tr>

                    <tr>
                        <th>Updated At</th>
                        <td>{{ $country->updated_at->format('d M Y H:i') }}</td>
                    </tr>

                </table>

            </div>

            <div class="card-footer">

                <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Back
                </a>

                <a href="{{ route('countries.edit', $country) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>

            </div>

        </div>

    </div>

</div>

@stop