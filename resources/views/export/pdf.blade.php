<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <title>Supply Chain Report</title>

    <style>

        body{
            font-family:Arial,Helvetica,sans-serif;
            margin:30px;
        }

        h2,h3{
            text-align:center;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-bottom:25px;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:13px;
        }

        table th{
            background:#eeeeee;
        }

    </style>

</head>

<body>

<h2>GLOBAL SUPPLY CHAIN RISK INTELLIGENCE PLATFORM</h2>

<h3>REPORT</h3>

<p>
Tanggal Cetak :
{{ date('d-m-Y H:i:s') }}
</p>

<hr>

<h3>Country Data</h3>

<table>

<thead>

<tr>

<th>No</th>
<th>Country</th>
<th>Capital</th>
<th>Region</th>
<th>Risk</th>
<th>Risk Score</th>

</tr>

</thead>

<tbody>

@foreach($countries as $country)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $country->name }}</td>
<td>{{ $country->capital }}</td>
<td>{{ $country->region }}</td>
<td>{{ $country->risk_level }}</td>
<td>{{ $country->risk_score }}</td>

</tr>

@endforeach

</tbody>

</table>

<h3>Supplier Data</h3>

<table>

<thead>

<tr>

<th>No</th>
<th>Name</th>
<th>Country</th>
<th>Risk Score</th>

</tr>

</thead>

<tbody>

@foreach($suppliers as $supplier)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $supplier->name }}</td>
<td>{{ $supplier->country }}</td>
<td>{{ $supplier->risk_score }}</td>

</tr>

@endforeach

</tbody>

</table>

<h3>Product Data</h3>

<table>

<thead>

<tr>

<th>No</th>
<th>Product</th>
<th>Supplier</th>
<th>Risk Score</th>

</tr>

</thead>

<tbody>

@foreach($products as $product)

<tr>

<td>{{ $loop->iteration }}</td>
<td>{{ $product->name }}</td>
<td>{{ $product->supplier }}</td>
<td>{{ $product->risk_score }}</td>

</tr>

@endforeach

</tbody>

</table>

<script>

window.onload=function(){

window.print();

}

</script>

</body>

</html>