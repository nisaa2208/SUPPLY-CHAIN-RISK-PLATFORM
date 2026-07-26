@php

header("Content-Type: application/vnd.ms-excel");

header("Content-Disposition: attachment; filename=SupplyChainReport.xls");

@endphp

<table border="1">

<tr>

<th>No</th>
<th>Country</th>
<th>Capital</th>
<th>Region</th>
<th>Risk</th>
<th>Risk Score</th>

</tr>

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

</table>