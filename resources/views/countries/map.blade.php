@extends('adminlte::page')

@section('title', 'Global Supply Chain Risk Map')

@section('content_header')

<h1>
    <i class="fas fa-globe-americas text-primary"></i>
    Global Supply Chain Risk Map
</h1>

@stop

@section('css')

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<style>

#map{

height:700px;

border-radius:10px;

}

.legend{

background:white;

padding:12px;

border-radius:8px;

box-shadow:0 0 10px rgba(0,0,0,.2);

line-height:24px;

}

.legend i{

width:18px;

height:18px;

float:left;

margin-right:8px;

opacity:.9;

}

</style>

@stop


@section('content')

<div class="row">

<div class="col-md-12">

<div class="card card-primary">

<div class="card-header">

<h3 class="card-title">

World Supply Chain Monitoring

</h3>

</div>

<div class="card-body">

<div id="map"></div>

</div>

</div>

</div>

</div>

@stop


@section('js')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

var map=L.map('map').setView([20,0],2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
maxZoom:18,
attribution:'© OpenStreetMap'
}
).addTo(map);

fetch("{{ route('api.world.map') }}")

.then(response=>response.json())

.then(function(countries){

countries.forEach(function(country){

let color='green';

if(country.risk_score>=80){

color='red';

}
else if(country.risk_score>=50){

color='orange';

}

L.circleMarker(
[
country.latitude,
country.longitude
],
{
radius:8,
color:color,
fillColor:color,
fillOpacity:.8,
weight:2
})
.addTo(map)
.bindPopup(

"<b>"+country.name+"</b><hr>"+

"<b>Region :</b> "+country.region+"<br>"+

"<b>Risk Score :</b> "+country.risk_score+"<br>"+

"<b>Risk Level :</b> "+country.risk_level+"<br>"+

"<b>Trade Index :</b> "+country.trade_index+"<br>"+

"<b>Shipping :</b> "+country.shipping_status

);

});

});

var legend=L.control({position:'bottomright'});

legend.onAdd=function(){

var div=L.DomUtil.create('div','legend');

div.innerHTML=

'<b>Risk Level</b><br><br>'+

'<i style="background:red"></i> High Risk<br>'+

'<i style="background:orange"></i> Medium Risk<br>'+

'<i style="background:green"></i> Low Risk';

return div;

};

legend.addTo(map);

</script>

@stop