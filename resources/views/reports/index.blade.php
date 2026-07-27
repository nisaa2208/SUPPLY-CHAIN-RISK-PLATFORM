@extends('adminlte::page')

@section('title','Reports')

@section('content_header')

<h1>

<i class="fas fa-file-alt text-primary"></i>

Reports

</h1>

@stop

@section('content')

<div class="row">

<div class="col-md-4">

<div class="small-box bg-info">

<div class="inner">

<h3>{{ $countries->count() }}</h3>

<p>Countries</p>

</div>

<div class="icon">

<i class="fas fa-globe"></i>

</div>

</div>

</div>

<div class="col-md-4">

<div class="small-box bg-success">

<div class="inner">

<h3>{{ $suppliers->count() }}</h3>

<p>Suppliers</p>

</div>

<div class="icon">

<i class="fas fa-truck"></i>

</div>

</div>

</div>

<div class="col-md-4">

<div class="small-box bg-warning">

<div class="inner">

<h3>{{ $products->count() }}</h3>

<p>Products</p>

</div>

<div class="icon">

<i class="fas fa-box"></i>

</div>

</div>

</div>

</div>

<div class="card">

<div class="card-header">

<h3 class="card-title">

Countries Report

</h3>

</div>

<div class="card-body table-responsive">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>No</th>

<th>Country</th>

<th>Region</th>

<th>Risk</th>

<th>Trade</th>

<th>Shipping</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $country->name }}</td>

<td>{{ $country->region }}</td>

<td>{{ $country->risk_score }}</td>

<td>{{ $country->trade_index }}</td>

<td>{{ $country->shipping_status }}</td>

</tr>

@endforeach

</tbody>
<div class="mb-3">

<a href="{{ route('export.pdf') }}"
class="btn btn-danger">

<i class="fas fa-file-pdf"></i>

Print PDF

</a>

<a href="{{ route('export.excel') }}"
class="btn btn-success">

<i class="fas fa-file-excel"></i>

Export Excel

</a>

</div>
</table>

</div>

</div>

@stop