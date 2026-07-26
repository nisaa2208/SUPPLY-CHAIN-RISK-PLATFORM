@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
<h1>
    <i class="fas fa-file-alt text-primary"></i>
    Supply Chain Reports
</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ \App\Models\Country::count() }}</h3>
                <p>Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Supplier::count() }}</h3>
                <p>Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\Product::count() }}</h3>
                <p>Products</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Users</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header bg-primary">

        <h3 class="card-title">
            System Report Summary
        </h3>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>

                    <th>Module</th>

                    <th>Total Data</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>Countries</td>
                    <td>{{ \App\Models\Country::count() }}</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>

                <tr>
                    <td>Suppliers</td>
                    <td>{{ \App\Models\Supplier::count() }}</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>

                <tr>
                    <td>Products</td>
                    <td>{{ \App\Models\Product::count() }}</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>

                <tr>
                    <td>Users</td>
                    <td>{{ \App\Models\User::count() }}</td>
                    <td><span class="badge badge-success">Active</span></td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@stop