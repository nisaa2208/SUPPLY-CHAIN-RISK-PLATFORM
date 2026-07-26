@extends('adminlte::page')

@section('title','Monitoring')

@section('content_header')

<h1>

<i class="fas fa-satellite-dish text-danger"></i>

Global Supply Chain Monitoring

</h1>

@stop

@section('content')

<div class="row">

    <div class="col-md-3">

        <div class="small-box bg-success">

            <div class="inner">

                <h3>98%</h3>

                <p>Shipping Success</p>

            </div>

            <div class="icon">

                <i class="fas fa-shipping-fast"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-warning">

            <div class="inner">

                <h3>18</h3>

                <p>High Risk Suppliers</p>

            </div>

            <div class="icon">

                <i class="fas fa-exclamation-triangle"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-primary">

            <div class="inner">

                <h3>{{ \App\Models\Product::count() }}</h3>

                <p>Total Products</p>

            </div>

            <div class="icon">

                <i class="fas fa-boxes"></i>

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="small-box bg-danger">

            <div class="inner">

                <h3>{{ \App\Models\Supplier::count() }}</h3>

                <p>Total Suppliers</p>

            </div>

            <div class="icon">

                <i class="fas fa-truck"></i>

            </div>

        </div>

    </div>

</div>

<div class="card">

<div class="card-header bg-dark">

<h3 class="card-title">

<i class="fas fa-bell"></i>

Risk Alert

</h3>

</div>

<div class="card-body">
<table class="table table-bordered table-hover">

    <thead class="bg-light">

        <tr>

            <th>Country</th>
            <th>Supplier</th>
            <th>Risk Score</th>
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        @foreach(\App\Models\Supplier::with('country')->get() as $supplier)

        <tr>

            <td>
                {{ optional($supplier->country)->name ?? '-' }}
            </td>

            <td>
                {{ $supplier->name }}
            </td>

            <td>

                @if($supplier->risk_score >= 80)

                    <span class="badge badge-danger">
                        {{ $supplier->risk_score }}
                    </span>

                @elseif($supplier->risk_score >= 60)

                    <span class="badge badge-warning">
                        {{ $supplier->risk_score }}
                    </span>

                @else

                    <span class="badge badge-success">
                        {{ $supplier->risk_score }}
                    </span>

                @endif

            </td>

            <td>

                @if($supplier->risk_score >=80)

                    <span class="text-danger">
                        High Risk
                    </span>

                @elseif($supplier->risk_score>=60)

                    <span class="text-warning">
                        Medium Risk
                    </span>

                @else

                    <span class="text-success">
                        Safe
                    </span>

                @endif

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

</div>

</div>

<div class="row">

    <div class="col-md-6">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">

                    Shipping Status

                </h3>

            </div>

            <div class="card-body">

                <table class="table table-striped">

                    <thead>

                        <tr>

                            <th>Country</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach(\App\Models\Country::all() as $country)

                        <tr>

                            <td>{{ $country->name }}</td>

                            <td>

                                @if($country->shipping_status=="Available")

                                    <span class="badge badge-success">

                                        Available

                                    </span>

                                @elseif($country->shipping_status=="Limited")

                                    <span class="badge badge-warning">

                                        Limited

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        Closed

                                    </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>
        <div class="col-md-6">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    Supply Chain Performance
                </h3>

            </div>

            <div class="card-body">

                <canvas id="monitorChart" height="220"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="card">

    <div class="card-header bg-info">

        <h3 class="card-title">

            <i class="fas fa-globe"></i>

            Country Status Summary

        </h3>

    </div>

    <div class="card-body">

        <div class="row">

            @foreach(\App\Models\Country::all() as $country)

            <div class="col-md-3 mb-3">

                <div class="card">

                    <div class="card-body text-center">

                        <h5>

                            {{ $country->name }}

                        </h5>

                        <hr>

                        <p>

                            <strong>Risk Score</strong>

                            <br>

                            {{ $country->risk_score }}

                        </p>

                        <p>

                            <strong>Trade Index</strong>

                            <br>

                            {{ $country->trade_index }}

                        </p>

                        @if($country->risk_level=="Low")

                            <span class="badge badge-success">

                                Low Risk

                            </span>

                        @elseif($country->risk_level=="Medium")

                            <span class="badge badge-warning">

                                Medium Risk

                            </span>

                        @else

                            <span class="badge badge-danger">

                                High Risk

                            </span>

                        @endif

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </div>

</div>

@stop

@section('js')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const monitor=document.getElementById('monitorChart');

new Chart(monitor,{

type:'line',

data:{

labels:[
'Jan',
'Feb',
'Mar',
'Apr',
'May',
'Jun'
],

datasets:[{

label:'Supply Chain Performance',

data:[
70,
72,
78,
82,
87,
91
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