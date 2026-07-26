@extends('adminlte::page')

@section('title', 'Global Search')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-search text-primary"></i>
        Global Search
    </h1>
</div>
@stop

@section('content')

<div class="card card-primary card-outline">

    <div class="card-header">
        <h3 class="card-title">
            Search Country, Supplier & Product
        </h3>
    </div>

    <div class="card-body">

        <form action="{{ route('search') }}" method="GET">

            <div class="input-group">

                <input
                    type="text"
                    name="keyword"
                    class="form-control"
                    placeholder="Type keyword..."
                    value="{{ $keyword }}">

                <div class="input-group-append">

                    <button class="btn btn-primary">

                        <i class="fas fa-search"></i>

                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


@if($keyword)

<div class="row">

    <!-- Countries -->

    <div class="col-md-4">

        <div class="card card-info">

            <div class="card-header">

                <h3 class="card-title">

                    🌍 Countries

                </h3>

            </div>

            <div class="card-body">

                @forelse($countries as $country)

                    <div class="border rounded p-2 mb-2">

                        <strong>{{ $country->name }}</strong><br>

                        <small>

                            {{ $country->capital }}

                        </small><br>

                        <span class="badge badge-info">

                            {{ $country->risk_level }}

                        </span>

                    </div>

                @empty

                    <div class="alert alert-secondary">

                        No country found.

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    <!-- Suppliers -->

    <div class="col-md-4">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">

                    🚚 Suppliers

                </h3>

            </div>

            <div class="card-body">

                @forelse($suppliers as $supplier)

                    <div class="border rounded p-2 mb-2">

                        <strong>{{ $supplier->name }}</strong>

                    </div>

                @empty

                    <div class="alert alert-secondary">

                        No supplier found.

                    </div>

                @endforelse

            </div>

        </div>

    </div>


    <!-- Products -->

    <div class="col-md-4">

        <div class="card card-warning">

            <div class="card-header">

                <h3 class="card-title">

                    📦 Products

                </h3>

            </div>

            <div class="card-body">

                @forelse($products as $product)

                    <div class="border rounded p-2 mb-2">

                        <strong>{{ $product->name }}</strong>

                    </div>

                @empty

                    <div class="alert alert-secondary">

                        No product found.

                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endif

@stop