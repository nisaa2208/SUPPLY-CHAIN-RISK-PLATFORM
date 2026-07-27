@extends('adminlte::page')

@section('title', 'Global Supply Chain Risk Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h1 class="font-weight-bold">
            <i class="fas fa-globe-asia text-primary"></i>
            Global Supply Chain Risk Dashboard
        </h1>
        <small class="text-muted">
            Real-Time Monitoring of Global Supply Chain Risks
        </small>
    </div>

    <div class="text-right">

        <div id="liveClock"
             style="font-size:15px;font-weight:bold;">
        </div>

        <a href="{{ route('dashboard') }}"
           class="btn btn-success mt-2">

            <i class="fas fa-sync"></i>
            Refresh

        </a>

    </div>

</div>
@stop

@section('content')

<div class="row">

    <div class="col-md-3">
        <div class="small-box bg-info">

            <div class="inner">
                <h3>{{ $countries }}</h3>
                <p>Total Countries</p>
            </div>

            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-success">

            <div class="inner">
                <h3>{{ $suppliers }}</h3>
                <p>Total Suppliers</p>
            </div>

            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-warning">

            <div class="inner">
                <h3>{{ $products }}</h3>
                <p>Total Products</p>
            </div>

            <div class="icon">
                <i class="fas fa-box"></i>
            </div>

        </div>
    </div>

    <div class="col-md-3">
        <div class="small-box bg-danger">

            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk Countries</p>
            </div>

            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

        </div>
    </div>

</div>

<div class="row mb-4">

    <div class="col-md-3">
        <a href="{{ route('countries.create') }}"
           class="btn btn-primary btn-block">

            <i class="fas fa-plus"></i>
            Add Country

        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('suppliers.create') }}"
           class="btn btn-success btn-block">

            <i class="fas fa-truck"></i>
            Add Supplier

        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('reports.index') }}"
           class="btn btn-danger btn-block">

            <i class="fas fa-file"></i>
            Reports

        </a>
    </div>

    <div class="col-md-3">
        <a href="{{ route('world.map') }}"
           class="btn btn-warning btn-block">

            <i class="fas fa-globe-americas"></i>
            World Map

        </a>
    </div>

</div>

<div class="row">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header bg-primary">

                <h3 class="card-title text-white">

                    <i class="fas fa-map-marked-alt"></i>

                    Global Risk Map

                </h3>

            </div>

            <div class="card-body">

                <div id="worldMap"
                     style="height:500px;">
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">

            <div class="card-header bg-danger">

                <h3 class="card-title text-white">

                    Top Risk Countries

                </h3>

            </div>

            <div class="card-body">

                @forelse($topRiskCountries as $country)

                    <div class="mb-3">

                        <strong>{{ $country->name }}</strong>

                        <small class="float-right">
                            {{ $country->risk_score }}%
                        </small>

                        <div class="progress mt-2">

                            <div class="progress-bar bg-danger"

                                 style="width: {{ $country->risk_score }}%;">

                            </div>

                        </div>

                    </div>

                @empty

                    <p class="text-center">

                        No data available

                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>
<div class="row mt-4">

    <div class="col-lg-7">

        <div class="card">

            <div class="card-header bg-success">

                <h3 class="card-title text-white">

                    <i class="fas fa-chart-line"></i>

                    Risk Trend

                </h3>

            </div>

            <div class="card-body">

                <canvas id="riskChart" height="120"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-5">

        <div class="card">

            <div class="card-header bg-warning">

                <h3 class="card-title">

                    Supplier Distribution

                </h3>

            </div>

            <div class="card-body">

                <canvas id="supplierChart" height="220"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header bg-primary">

                <h3 class="card-title text-white">

                    Latest Country Risk Data

                </h3>

            </div>

            <div class="card-body p-0">

                <table class="table table-striped table-hover mb-0">

                    <thead>

                    <tr>

                        <th>No</th>

                        <th>Country</th>

                        <th>Risk Score</th>

                        <th>Risk Level</th>

                        <th>Trade Index</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($latestCountries as $index => $country)

                    <tr>

                        <td>{{ $index+1 }}</td>

                        <td>{{ $country->name }}</td>

                        <td>{{ $country->risk_score }}%</td>

                        <td>{{ $country->risk_level }}</td>

                        <td>{{ $country->trade_index }}</td>

                        <td>

                            @if($country->risk_level=='High')

                                <span class="badge badge-danger">High</span>

                            @elseif($country->risk_level=='Medium')

                                <span class="badge badge-warning">Medium</span>

                            @else

                                <span class="badge badge-success">Low</span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No data available

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-info">

                <h3 class="card-title text-white">

                    Recent Suppliers

                </h3>

            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead>

                    <tr>

                        <th>Supplier</th>

                        <th>Country</th>

                        <th>Status</th>

                    </tr>

                    </thead>

                    <tbody>

                    @forelse($recentSuppliers as $supplier)

                    <tr>

                        <td>{{ $supplier->name }}</td>

                        <td>{{ $supplier->country->name ?? '-' }}</td>

                        <td>

                            @if($supplier->supply_status=='Active')

                                <span class="badge badge-success">

                                    Active

                                </span>

                            @else

                                <span class="badge badge-secondary">

                                    Inactive

                                </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3" class="text-center">

                            No supplier data

                        </td>

                    </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-danger">

                <h3 class="card-title text-white">

                    Dashboard Summary

                </h3>

            </div>

            <div class="card-body">

                <div class="alert alert-success">

                    Countries :
                    <strong>{{ $countries }}</strong>

                </div>

                <div class="alert alert-primary">

                    Suppliers :
                    <strong>{{ $suppliers }}</strong>

                </div>

                <div class="alert alert-warning">

                    Products :
                    <strong>{{ $products }}</strong>

                </div>

                <div class="alert alert-danger">

                    High Risk :
                    <strong>{{ $highRisk }}</strong>

                </div>

            </div>

        </div>

    </div>

</div>
@stop

@section('css')

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>

.small-box{
    border-radius:15px;
}

.card{
    border-radius:15px;
}

.progress{
    height:20px;
}

#worldMap{
    border-radius:15px;
}

#liveClock{
    font-size:15px;
    font-weight:bold;
}

body.dark-mode{
    background:#111827;
}

body.dark-mode .card{
    background:#1f2937;
    color:white;
}

body.dark-mode table{
    color:white;
}

body.dark-mode .table thead{
    background:#374151;
}

</style>

@stop

@section('js')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

function updateClock(){

    let now=new Date();

    document.getElementById("liveClock").innerHTML=
    now.toLocaleDateString()+"<br>"+now.toLocaleTimeString();

}

updateClock();

setInterval(updateClock,1000);

</script>

<script>

var map=L.map('worldMap').setView([20,0],2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
attribution:'© OpenStreetMap'
}).addTo(map);

@foreach($mapCountries as $country)

L.marker([
{{ $country->latitude }},
{{ $country->longitude }}
])

.addTo(map)

.bindPopup(

"<b>{{ $country->name }}</b><br>"+
"Risk : {{ $country->risk_level }}<br>"+
"Score : {{ $country->risk_score }}"

);

@endforeach

</script>

<script>

new Chart(document.getElementById('riskChart'),{

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

label:'Risk Index',

data:[
25,
35,
45,
40,
60,
55
],

fill:false,

borderWidth:3

}]

}

});

new Chart(document.getElementById('supplierChart'),{

type:'doughnut',

data:{

labels:[
'Asia',
'Europe',
'America',
'Africa'
],

datasets:[{

data:[
45,
25,
20,
10
]

}]

}

});

</script>

<script>

document.querySelectorAll(".small-box").forEach(function(box){

box.addEventListener("mouseenter",function(){

box.style.transform="translateY(-6px)";
box.style.transition=".3s";

});

box.addEventListener("mouseleave",function(){

box.style.transform="translateY(0px)";

});

});

</script>

@stop