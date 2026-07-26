@extends('adminlte::page')

@section('title', 'Countries Management')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-globe-asia text-primary"></i>
        Countries Management
    </h1>

    <a href="{{ route('countries.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Add Country
    </a>
</div>
@stop

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <i class="fas fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3>{{ $countries->count() }}</h3>
                <p>Total Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>
</div>

<div class="card card-primary shadow">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i>
            Search & Filter
        </h3>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('countries.index') }}">
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Country..."
                        value="{{ request('search') }}">
                </div>

                <div class="col-md-3 mb-2">
                    <select name="risk_level" class="form-control">
                        <option value="">All Risk Level</option>

                        <option value="Low" {{ request('risk_level') == 'Low' ? 'selected' : '' }}>
                            Low
                        </option>

                        <option value="Medium" {{ request('risk_level') == 'Medium' ? 'selected' : '' }}>
                            Medium
                        </option>

                        <option value="High" {{ request('risk_level') == 'High' ? 'selected' : '' }}>
                            High
                        </option>
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <select name="region" class="form-control">
                        <option value="">All Region</option>

                        @foreach($regions as $region)
                            <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <button class="btn btn-primary btn-block" type="submit">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-3">
            <a href="{{ route('countries.index') }}" class="btn btn-secondary">
                <i class="fas fa-sync-alt"></i> Reset Filter
            </a>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-header bg-light">
        <h3 class="card-title">
            <i class="fas fa-list"></i>
            Countries List
        </h3>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Country</th>
                    <th>Code</th>
                    <th>Capital</th>
                    <th>Region</th>
                    <th>Currency</th>
                    <th>Population</th>
                    <th>Risk</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td>
                            {{ method_exists($countries, 'firstItem')
                                ? $countries->firstItem() + $loop->index
                                : $loop->iteration }}
                        </td>

                        <td>
                            🌍 {{ $country->name }}
                        </td>

                        <td>{{ $country->code }}</td>
                        <td>{{ $country->capital }}</td>
                        <td>{{ $country->region }}</td>
                        <td>{{ $country->currency }}</td>
                        <td>{{ number_format($country->population) }}</td>

                        <td>
                            @if($country->risk_level == 'Low')
                                <span class="badge badge-success">Low</span>
                            @elseif($country->risk_level == 'Medium')
                                <span class="badge badge-warning">Medium</span>
                            @else
                                <span class="badge badge-danger">High</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('countries.show', $country->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('countries.edit', $country->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('countries.destroy', $country->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this country?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            No country data available.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($countries, 'links'))
        <div class="card-footer clearfix">
            {{ $countries->links() }}
        </div>
    @endif
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>
#worldMap{
    width:100%;
    height:550px;
}

.leaflet-container{
    width:100%;
    height:550px;
}

.leaflet-pane,
.leaflet-map-pane,
.leaflet-tile-pane{
    z-index:1;
}
</style>

@stop

@section('js')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // kosong dulu
});
</script>
@stop