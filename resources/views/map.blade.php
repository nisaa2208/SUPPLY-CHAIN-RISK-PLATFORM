@extends('adminlte::page')

@section('title','World Risk Map')


@section('content_header')

<h1>

🌍 World Supply Chain Risk Map

</h1>

@endsection



@section('content')


<div class="card shadow">


<div class="card-header bg-primary">

<h3>

Global Supply Chain Monitoring

</h3>

</div>



<div class="card-body">


<div class="alert alert-info">

This map displays countries and their current supply chain risk level.

</div>



<div class="row">


@foreach($countries as $country)


<div class="col-md-4">


<div class="card">


<div class="card-body">


<h4>

{{ $country->name }}

</h4>


<p>

Capital :
{{ $country->capital }}

</p>


<p>

Region :
{{ $country->region }}

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


<hr>


<p>

Supply Status :

<b>

{{ $country->supply_status }}

</b>

</p>



<p>

Shipping Status :

<b>

{{ $country->shipping_status }}

</b>

</p>


</div>


</div>


</div>


@endforeach



</div>



</div>


</div>


@endsection