@extends('adminlte::page')

@section('title', 'About System Platform')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-info-circle text-primary mr-2"></i>
            About Supply Chain Risk Platform
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            System Architecture Overview & Technology Stack Details
        </div>
    </div>
</div>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body text-center p-5">
                <div class="d-inline-block p-4 rounded-circle bg-light mb-3">
                    <i class="fas fa-shield-alt fa-4x text-primary"></i>
                </div>

                <h2 class="font-weight-bold text-dark mb-2">
                    Global Supply Chain Risk Platform
                </h2>

                <p class="text-muted max-w-2xl mx-auto mb-4" style="max-width: 600px;">
                    An enterprise-grade real-time monitoring and analytics system designed to identify sovereign risks, supplier disruptions, and global trade vulnerabilities.
                </p>

                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <span class="badge badge-primary px-3 py-2 font-weight-bold" style="font-size: 0.88rem;">
                        <i class="fas fa-check-circle mr-1"></i> Version 1.0 Enterprise
                    </span>
                    <span class="badge badge-success px-3 py-2 font-weight-bold" style="font-size: 0.88rem;">
                        <i class="fas fa-server mr-1"></i> System Operational
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-microchip text-primary mr-2"></i> Technology Stack Specification
                </h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <tbody>
                        <tr>
                            <th width="35%" class="pl-4 font-weight-bold text-muted">Core Framework</th>
                            <td><span class="font-weight-bold text-dark">Laravel {{ app()->version() }}</span></td>
                        </tr>
                        <tr>
                            <th class="pl-4 font-weight-bold text-muted">PHP Engine</th>
                            <td><span class="font-weight-bold text-dark">PHP {{ PHP_VERSION }}</span></td>
                        </tr>
                        <tr>
                            <th class="pl-4 font-weight-bold text-muted">UI Architecture</th>
                            <td><span class="font-weight-bold text-dark">AdminLTE 3 + Custom Modern CSS Theme</span></td>
                        </tr>
                        <tr>
                            <th class="pl-4 font-weight-bold text-muted">Geographic GIS Engine</th>
                            <td><span class="font-weight-bold text-dark">Leaflet.js + OpenStreetMap</span></td>
                        </tr>
                        <tr>
                            <th class="pl-4 font-weight-bold text-muted">Analytics Engine</th>
                            <td><span class="font-weight-bold text-dark">Chart.js Visualizations</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h3 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-layer-group text-success mr-2"></i> System Features Overview
                </h3>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-globe text-primary fa-lg mr-3 mt-1"></i>
                    <div>
                        <h6 class="font-weight-bold mb-1">Global Sovereign Risk Indexing</h6>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Tracks country trade stability, economic risk scores, and shipping statuses.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-3">
                    <i class="fas fa-truck text-success fa-lg mr-3 mt-1"></i>
                    <div>
                        <h6 class="font-weight-bold mb-1">Supplier Network Auditing</h6>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Monitors supplier health, active statuses, contact details, and location risk.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle text-danger fa-lg mr-3 mt-1"></i>
                    <div>
                        <h6 class="font-weight-bold mb-1">Automated Global Alerting</h6>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">Real-time notifications and alerts for critical logistics delays.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop