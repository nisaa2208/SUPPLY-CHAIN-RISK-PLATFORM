@extends('adminlte::page')

@section('title', 'REST Countries API')

@section('content_header')
    <h1>
        <i class="fas fa-globe"></i>
        REST Countries API
    </h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-primary">
        <h3 class="card-title">
            <i class="fas fa-globe-asia"></i>
            Global Country Information
        </h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Flag</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>Currency</th>
                        <th>Population</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($countries as $index => $country)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td width="90">
                                @if(!empty($country['flag']))
                                    <img src="{{ $country['flag'] }}" width="70" class="img-thumbnail">
                                @else
                                    -
                                @endif
                            </td>

                            <td>{{ $country['name'] }}</td>

                            <td>{{ $country['region'] }}</td>

                            <td>{{ $country['currency'] }}</td>

                            <td>{{ number_format($country['population']) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                Data tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@stop