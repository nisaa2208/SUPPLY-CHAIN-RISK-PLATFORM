@extends('adminlte::page')

@section('title', 'Notifications')

@section('content_header')
<h1>
    <i class="fas fa-bell text-warning"></i>
    Notifications
</h1>
@stop

@section('content')

<div class="card shadow">

    <div class="card-header bg-warning">
        <h3 class="card-title">
            <i class="fas fa-bell"></i>
            System Notifications
        </h3>
    </div>

    <div class="card-body">

        @forelse($notifications as $notification)

        <div class="alert alert-{{ $notification['color'] }}">

            <h5>
                <i class="{{ $notification['icon'] }}"></i>
                {{ $notification['title'] }}
            </h5>

            <p class="mb-1">
                {{ $notification['message'] }}
            </p>

            <small class="text-muted">
                {{ $notification['time'] }}
            </small>

        </div>

        @empty

        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            There are currently no high-risk notifications.
        </div>

        @endforelse

    </div>

</div>

@stop