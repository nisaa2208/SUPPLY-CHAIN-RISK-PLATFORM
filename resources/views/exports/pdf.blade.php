<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Supply Chain Report</title>

<style>

body{

font-family:Arial;

font-size:13px;

}

table{

width:100%;

border-collapse:collapse;

margin-top:20px;

}

th,td{

border:1px solid black;

padding:8px;

}

th{

background:#efefef;

}

h2{

text-align:center;

}

</style>

</head>

<body>

<h2>

Global Supply Chain Report

</h2>

<table>

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

</table>

<script>

window.print();

</script>

</body>

</html>