@extends('adminlte::page')

@section('title', 'World Bank API')

@section('content_header')
<h1>
    <i class="fas fa-chart-line"></i>
    World Bank API
</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-warning">
        <h3 class="card-title">
            GDP Data from World Bank
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Country</th>
                    <th>Year</th>
                    <th>GDP (USD)</th>
                </tr>
            </thead>

            <tbody>

            @foreach($countries as $country)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $country['country']['value'] }}</td>

                    <td>{{ $country['date'] }}</td>

                    <td>{{ number_format($country['value']) }}</td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@stop