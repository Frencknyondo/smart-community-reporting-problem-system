@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="notification-detail-card">
            <div class="notification-detail-card__icon">
                <i class="bi bi-bell"></i>
            </div>
            <div class="notification-detail-card__body">
                <h2 class="h5 mb-2">{{ $notification->metadata['title'] ?? $notification->subject_name ?? 'Notification' }}</h2>
                <p class="text-muted mb-0">{{ $notification->description ?? 'No message available.' }}</p>
                <small class="notification-detail-card__time">{{ $notification->created_at?->diffForHumans() }}</small>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .notification-detail-card {
            display: flex;
            align-items: flex-start;
            gap: 0.9rem;
            background: #ffffff;
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.14);
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.04);
        }

        .notification-detail-card__icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-primary-600);
            background: var(--color-primary-50);
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.12);
        }

        .notification-detail-card__body {
            min-width: 0;
        }

        .notification-detail-card__body h2 {
            color: #111827;
            font-weight: 800;
        }

        .notification-detail-card__time {
            display: block;
            margin-top: 0.7rem;
            color: var(--color-slate-500);
        }
    </style>
@endpush

