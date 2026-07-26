@extends('adminlte::page')

@section('title', 'Exchange Rate API')

@section('content_header')
<h1>
    <i class="fas fa-dollar-sign"></i>
    Exchange Rate API
</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-success">
        <h3 class="card-title">
            <i class="fas fa-coins"></i>
            USD Exchange Rates
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">
                <tr>
                    <th width="80">No</th>
                    <th>Currency</th>
                    <th>Exchange Rate</th>
                </tr>
            </thead>

            <tbody>

                @foreach($rates as $currency => $rate)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $currency }}</td>
                    <td>{{ number_format($rate, 4) }}</td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@stop