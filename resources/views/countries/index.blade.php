@extends('adminlte::page')

@section('title', 'Countries')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Countries</h1>

    <a href="{{ route('countries.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Country
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Country List
        </h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

            <tr>

                <th>No</th>
                <th>Country</th>
                <th>Code</th>
                <th>Region</th>
                <th>Risk Score</th>
                <th>Risk Level</th>
                <th>Trade Index</th>
                <th>Shipping</th>
                <th width="170">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($countries as $country)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>{{ $country->name }}</td>

                <td>{{ $country->code }}</td>

                <td>{{ $country->region }}</td>

                <td>{{ $country->risk_score }}</td>

                <td>

                    @if($country->risk_level=='High')
                        <span class="badge badge-danger">High</span>

                    @elseif($country->risk_level=='Medium')
                        <span class="badge badge-warning">Medium</span>

                    @else
                        <span class="badge badge-success">Low</span>

                    @endif

                </td>

                <td>{{ $country->trade_index }}</td>

                <td>{{ $country->shipping_status }}</td>

                <td>

                    <a href="{{ route('countries.edit',$country->id) }}"
                       class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <form action="{{ route('countries.destroy',$country->id) }}"
                          method="POST"
                          style="display:inline;">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this country?')">

                            Delete

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="9" class="text-center">

                    No data available

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="card-footer">

        {{ $countries->links() }}

    </div>

</div>

@stop