@extends('adminlte::page')

@section('title', 'Analytics')

@section('content_header')
<h1>
    <i class="fas fa-chart-line text-success"></i>
    Supply Chain Analytics
</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="info-box bg-primary">
            <span class="info-box-icon">
                <i class="fas fa-globe"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Countries</span>
                <span class="info-box-number">{{ \App\Models\Country::count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon">
                <i class="fas fa-truck"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Suppliers</span>
                <span class="info-box-number">{{ \App\Models\Supplier::count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon">
                <i class="fas fa-box"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Products</span>
                <span class="info-box-number">{{ \App\Models\Product::count() }}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box bg-danger">
            <span class="info-box-icon">
                <i class="fas fa-users"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number">{{ \App\Models\User::count() }}</span>
            </div>
        </div>
    </div>

</div>

<div class="card">

    <div class="card-header bg-success">

        <h3 class="card-title">
            Overall Supply Chain Statistics
        </h3>

    </div>

    <div class="card-body">

        <canvas id="analyticsChart" height="120"></canvas>

    </div>

</div>

@stop

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx=document.getElementById('analyticsChart');

new Chart(ctx,{
    type:'line',
    data:{
        labels:[
            'Countries',
            'Suppliers',
            'Products',
            'Users'
        ],
        datasets:[{
            label:'Total',
            data:[
                {{ \App\Models\Country::count() }},
                {{ \App\Models\Supplier::count() }},
                {{ \App\Models\Product::count() }},
                {{ \App\Models\User::count() }}
            ],
            fill:false,
            tension:0.4
        }]
    },
    options:{
        responsive:true,
        maintainAspectRatio:false
    }
});

</script>

@stop