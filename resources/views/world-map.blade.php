@extends('adminlte::page')

@section('title','World Map')

@section('content_header')
<h1>
    <i class="fas fa-globe"></i>
    Global Supply Chain Risk Map
</h1>
@stop

@section('css')

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<style>

#map{

height:650px;

border-radius:10px;

}

</style>

@stop

@section('content')

<div class="card">

<div class="card-body">

<div id="map"></div>

</div>

</div>

@stop

@section('js')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

var map=L.map('map').setView([20,0],2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
maxZoom:18
}
).addTo(map);

@foreach($countries as $country)

var color='green';

@if($country->risk_score>=80)

color='red';

@elseif($country->risk_score>=50)

color='orange';

@endif

L.circleMarker(
[
{{ $country->latitude }},
{{ $country->longitude }}
],
{
radius:8,
color:color,
fillColor:color,
fillOpacity:0.8
}
)
.addTo(map)
.bindPopup(`
<b>{{ $country->name }}</b><br>
Risk Score : {{ $country->risk_score }}<br>
Risk Level : {{ $country->risk_level }}<br>
Trade Index : {{ $country->trade_index }}<br>
Shipping : {{ $country->shipping_status }}
`);

@endforeach

</script>

@stop