@extends('adminlte::page')

@section('title', 'About System')

@section('content_header')
<h1>
    <i class="fas fa-info-circle text-primary"></i>
    About System
</h1>
@stop

@section('content')

<div class="card">

    <div class="card-header bg-primary">

        <h3 class="card-title">
            Global Supply Chain Risk Intelligence Platform
        </h3>

    </div>

    <div class="card-body">

        <h4>Project Information</h4>

        <table class="table table-bordered">

            <tr>
                <th width="250">Application Name</th>
                <td>Global Supply Chain Risk Intelligence Platform</td>
            </tr>

            <tr>
                <th>Framework</th>
                <td>Laravel 9</td>
            </tr>

            <tr>
                <th>Template</th>
                <td>AdminLTE 3</td>
            </tr>

            <tr>
                <th>Database</th>
                <td>MySQL</td>
            </tr>

            <tr>
                <th>Programming Language</th>
                <td>PHP 8</td>
            </tr>

        </table>

        <br>

        <h4>Main Features</h4>

        <ul>

            <li>Dashboard Monitoring</li>

            <li>Countries Management</li>

            <li>Supplier Management</li>

            <li>Product Management</li>

            <li>Global Risk Alert</li>

            <li>World Map Visualization</li>

            <li>Analytics Dashboard</li>

            <li>REST API Integration</li>

            <li>Weather Information</li>

            <li>Exchange Rate Monitoring</li>

            <li>World Bank API</li>

            <li>Global News</li>

            <li>PDF & Excel Export</li>

        </ul>

        <hr>

        <h4>Developer</h4>

        <p>

            This application was developed as a final project for the
            Supply Chain Management course using Laravel Framework.

        </p>

    </div>

</div>

@stop