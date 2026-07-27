<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Supply Chain Risk Report</title>

<style>

body{

    font-family: DejaVu Sans;

    font-size:12px;

}

table{

    width:100%;

    border-collapse:collapse;

}

table th,
table td{

    border:1px solid #000;

    padding:8px;

}

table th{

    background:#dddddd;

}

h2{

    text-align:center;

}

</style>

</head>

<body>

<h2>

GLOBAL SUPPLY CHAIN RISK REPORT

</h2>

<table>

<thead>

<tr>

<th>No</th>

<th>Country</th>

<th>Risk Level</th>

<th>Risk Score</th>

<th>Trade Index</th>

<th>Shipping Status</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $country->name }}

</td>

<td>

{{ $country->risk_level }}

</td>

<td>

{{ $country->risk_score }}

</td>

<td>

{{ $country->trade_index }}

</td>

<td>

{{ $country->shipping_status }}

</td>

</tr>

@endforeach

</tbody>

</table>

<br>

<p>

Generated :
{{ now()->format('d-m-Y H:i') }}

</p>

</body>

</html>