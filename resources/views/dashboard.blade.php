@extends('adminlte::page')

@section('title', 'Global Supply Chain Risk Dashboard')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="font-weight-bold">
            <i class="fas fa-globe-asia text-primary"></i>
            Global Supply Chain Risk Dashboard
        </h1>
        <small class="text-muted">
            Real-Time Monitoring of Global Supply Chain Risks
        </small>
    </div>

    <div>
        <button class="btn btn-success">
            <i class="fas fa-sync"></i>
            Refresh
        </button>
    </div>
</div>
@stop

@section('content')

<div class="row">

    <div class="col-lg-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $countries }}</h3>
                <p>Countries</p>
            </div>
            <div class="icon">
                <i class="fas fa-globe"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $suppliers }}</h3>
                <p>Suppliers</p>
            </div>
            <div class="icon">
                <i class="fas fa-industry"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $highRisk }}</h3>
                <p>High Risk</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $products }}</h3>
                <p>Alerts</p>
            </div>
            <div class="icon">
                <i class="fas fa-bell"></i>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Global Risk Map
                </h3>
            </div>

            <div class="card-body">

                <div id="worldMap"
                     style="height:550px;border-radius:10px;">
                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">

            <div class="card-header bg-danger">
                <h3 class="card-title">
                    Top Risk Countries
                </h3>
            </div>

            <div class="card-body">

                @foreach($topRiskCountries as $country)

                    <div class="mb-3">

                        <strong>{{ $country->name }}</strong>

                        <div class="progress">

                            <div class="progress-bar bg-danger"
                                 style="width: {{ $country->risk_score }}%">
                                {{ $country->risk_score }}%
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>
<div class="row">

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-primary">

                <h3 class="card-title">
                    Monthly Risk Trend
                </h3>

            </div>

            <div class="card-body">

                <canvas id="riskChart" height="150"></canvas>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card">

            <div class="card-header bg-success">

                <h3 class="card-title">
                    Risk Distribution
                </h3>

            </div>

            <div class="card-body">

                <canvas id="pieChart" height="150"></canvas>

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    Latest Supply Chain Monitoring
                </h3>

            </div>

            <div class="card-body table-responsive p-0">
<table class="table table-striped table-bordered table-hover">

    <thead>

        <tr>

            <th>Country</th>
            <th>Risk Level</th>
            <th>Risk Score</th>
            <th>Trade Index</th>
            <th>Shipping Status</th>

        </tr>

    </thead>

    <tbody>

        @forelse($latestCountries as $country)

            <tr>

                <td>{{ $country->name }}</td>

                <td>

                    @if($country->risk_level == 'High')

                        <span class="badge badge-danger">
                            High
                        </span>

                    @elseif($country->risk_level == 'Medium')

                        <span class="badge badge-warning">
                            Medium
                        </span>

                    @else

                        <span class="badge badge-success">
                            Low
                        </span>

                    @endif

                </td>

                <td>

                    {{ $country->risk_score }}%

                </td>

                <td>

                    {{ $country->trade_index }}

                </td>

                <td>

                    @if($country->shipping_status == 'Open')

                        <span class="badge badge-success">
                            Open
                        </span>

                    @elseif($country->shipping_status == 'Limited')

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

        @empty

            <tr>

                <td colspan="5" class="text-center">

                    No Data Available

                </td>

            </tr>

        @endforelse

    </tbody>

</table>

            </div>

        </div>

    </div>

</div>

@stop

@section('css')
<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

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

    // ===========================
    // LEAFLET MAP
    // ===========================

  var map = L.map('worldMap', {
    center: [20, 0],
    zoom: 2,
    zoomControl: true
});

    L.tileLayer(
        'https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',
        {
            attribution:
            '&copy; OpenStreetMap &copy; CARTO',

            maxZoom: 18
        }

    ).addTo(map);
setTimeout(function () {
    map.invalidateSize();
}, 500);
    const countries = @json($mapCountries ?? []);

    countries.forEach(function(country){

    let color = "#28a745"; // Low

    if(country.risk_level === "High"){

        color = "#dc3545";

    }else if(country.risk_level === "Medium"){

        color = "#ffc107";

    }

    L.circleMarker(
        [country.latitude, country.longitude],
        {

            radius:8,
            weight:2,
            color:"#ffffff",
            fillColor:color,
            fillOpacity:0.9

        }

    ).addTo(map)

    .bindPopup(`
        <div style="min-width:180px">

            <h6><b>${country.name}</b></h6>

            <hr style="margin:5px 0">

            <b>Risk Level :</b> ${country.risk_level}<br>

            <b>Risk Score :</b> ${country.risk_score}%<br>

            <b>Trade Index :</b> ${country.trade_index}<br>

            <b>Shipping :</b> ${country.shipping_status}

        </div>
    `);

});

setTimeout(function () {
    map.invalidateSize();
    map.setView([20, 0], 2);
}, 800);

    // ===========================
    // LEGEND
    // ===========================

    var legend = L.control({position:'bottomright'});

    legend.onAdd = function(){

        var div = L.DomUtil.create('div','info legend');

        div.innerHTML =

        '<div style="background:white;padding:10px;border-radius:8px;">'+

        '<b>Risk Level</b><br><br>'+

        '<i style="background:red;width:12px;height:12px;display:inline-block;border-radius:50%;"></i> High<br>'+

        '<i style="background:orange;width:12px;height:12px;display:inline-block;border-radius:50%;"></i> Medium<br>'+

        '<i style="background:green;width:12px;height:12px;display:inline-block;border-radius:50%;"></i> Low'+

        '</div>';

        return div;

    };

    legend.addTo(map);
    var legend = L.control({ position: "bottomright" });

legend.onAdd = function () {

    var div = L.DomUtil.create("div", "info legend");

    div.innerHTML = `
        <div style="
            background:#fff;
            padding:10px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,.2);
            font-size:13px;
        ">
            <b>Risk Level</b><br><br>

            <span style="
                display:inline-block;
                width:12px;
                height:12px;
                border-radius:50%;
                background:red;
            "></span> High Risk<br>

            <span style="
                display:inline-block;
                width:12px;
                height:12px;
                border-radius:50%;
                background:orange;
            "></span> Medium Risk<br>

            <span style="
                display:inline-block;
                width:12px;
                height:12px;
                border-radius:50%;
                background:green;
            "></span> Low Risk
        </div>
    `;

    return div;

};

legend.addTo(map);
    // ===========================
    // LINE CHART
    // ===========================

   
const riskCtx = document.getElementById('riskChart');

if(riskCtx){

    new Chart(riskCtx,{

        type:'bar',

        data:{

            labels:[
                'Low Risk',
                'Medium Risk',
                'High Risk'
            ],

            datasets:[{

                label:'Jumlah Negara',

                data:@json($riskChart),

                backgroundColor:[
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],

                borderRadius:10

            }]

        },

        options:{

            responsive:true,

            maintainAspectRatio:false,

            plugins:{
                legend:{
                    display:false
                }
            },

            scales:{
                y:{
                    beginAtZero:true
                }
            }

        }

    });

}

    // ===========================
    // PIE CHART
    // ===========================
const pieCtx = document.getElementById('pieChart');

if (pieCtx) {

    new Chart(pieCtx, {

        type: 'doughnut',

        data: {

            labels: [
                'Low Risk',
                'Medium Risk',
                'High Risk'
            ],

            datasets: [{

                data: @json($riskChart),

                backgroundColor: [
                    '#28a745',
                    '#ffc107',
                    '#dc3545'
                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    position: 'bottom'
                }

            }

        }

    });

}
        // ===========================
    // AUTO REFRESH TIME
    // ===========================

    function updateTime(){

        const now = new Date();

        const time =
            now.toLocaleDateString() +
            " " +
            now.toLocaleTimeString();

        const el = document.getElementById("lastUpdate");

        if(el){

            el.innerHTML = time;

        }

    }

    updateTime();

    setInterval(updateTime,1000);

    // ===========================
    // MAP AUTO FIT
    // ===========================

    if(countries.length > 0){

        const group = [];

        countries.forEach(function(item){

            if(item.latitude && item.longitude){

                group.push([
                    item.latitude,
                    item.longitude
                ]);

            }

        });

        if(group.length){

           map.fitBounds(bounds, {
    padding: [80,80],
    maxZoom: 3
});

        }

    }

}); // END DOMContentLoaded

</script>

@stop