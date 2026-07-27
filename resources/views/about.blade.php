@extends('adminlte::page')

@section('title', 'About')

@section('content_header')
<h1>
    <i class="fas fa-info-circle text-primary"></i>
    About Application
</h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-12">

        <div class="card shadow">

            <div class="card-body text-center">

                <i class="fas fa-globe fa-5x text-primary mb-3"></i>

                <h2 class="font-weight-bold">
                    Global Supply Chain Risk Dashboard
                </h2>

                <p class="text-muted">
                    Risk Monitoring & Analytics System
                </p>

                <hr>

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Application</th>
                        <td>Global Supply Chain Risk Dashboard</td>
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
                        <th>Language</th>
                        <td>PHP 8</td>
                    </tr>

                    <tr>
                        <th>Version</th>
                        <td>1.0</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@stop