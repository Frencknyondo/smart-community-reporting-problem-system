@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-2">{{ $notification->metadata['title'] ?? $notification->subject_name ?? 'Notification' }}</h2>
                <p class="text-muted mb-0">{{ $notification->description ?? 'No message available.' }}</p>
            </div>
        </div>
    </div>
@endsection

