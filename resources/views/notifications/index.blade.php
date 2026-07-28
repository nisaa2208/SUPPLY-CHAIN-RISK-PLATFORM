@extends('adminlte::page')

@section('title', 'System Notifications')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-2">
    <div>
        <h1 class="font-weight-bold mb-1" style="font-size: 1.75rem;">
            <i class="fas fa-bell text-warning mr-2"></i>
            System Notifications & Alerts
        </h1>
        <div class="text-muted" style="font-size: 0.88rem;">
            Real-Time System Log Events & High Priority Risk Broadcasts
        </div>
    </div>
    <div>
        <span class="badge badge-warning px-3 py-2" style="font-size:0.85rem;">
            <i class="fas fa-inbox mr-1"></i> Notifications Feed
        </span>
    </div>
</div>
@stop

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h3 class="card-title font-weight-bold text-dark mb-0">
            <i class="fas fa-stream text-primary mr-2"></i> Activity Notification Feed
        </h3>
    </div>

    <div class="card-body p-4">
        @forelse($notifications as $notification)
            <div class="alert alert-{{ $notification['type'] }} shadow-sm border-0 mb-3" style="border-radius: var(--radius-md);">
                <div class="d-flex align-items-start">
                    <div class="mr-3 mt-1">
                        <i class="{{ $notification['icon'] }} fa-lg"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="font-weight-bold mb-1">{{ $notification['title'] }}</h6>
                        <p class="mb-2" style="font-size: 0.9rem; opacity: 0.95;">
                            {{ $notification['message'] }}
                        </p>
                        <div class="d-flex align-items-center" style="font-size: 0.78rem; opacity: 0.8;">
                            <i class="fas fa-clock mr-1"></i> {{ $notification['time']->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <h5 class="font-weight-bold text-muted">No New Notifications</h5>
                <p class="text-muted mb-0">You're all caught up! All supply chain systems are operating normally.</p>
            </div>
        @endforelse
    </div>
</div>
@stop