@extends('adminlte::page')

@section('title', 'Global Alert')

@section('content_header')

<h1>
    <i class="fas fa-exclamation-triangle text-danger"></i>
    Global Risk Alert
</h1>

@stop

@section('content')

<div class="card card-danger">

    <div class="card-header">

        <h3 class="card-title">

            High Risk Countries

        </h3>

    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered table-hover">

            <thead class="bg-danger">

                <tr>

                    <th>No</th>

                    <th>Country</th>

                    <th>Region</th>

                    <th>Risk Score</th>

                    <th>Risk Level</th>

                    <th>Trade Index</th>

                    <th>Shipping Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($alerts as $country)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $country->name }}</td>

                    <td>{{ $country->region }}</td>

                    <td>{{ $country->risk_score }}</td>

                    <td>
                        {!! $country->risk_badge !!}
                    </td>

                    <td>{{ $country->trade_index }}</td>

                    <td>{{ $country->shipping_status }}</td>

                </tr>

                @empty

                <tr>

                    <td colspan="7" class="text-center">
                        No High Risk Countries Found.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop