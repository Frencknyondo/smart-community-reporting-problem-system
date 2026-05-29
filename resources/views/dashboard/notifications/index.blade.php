@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="notification-page-card">
            <h2>Notifications</h2>
            <p class="text-muted">All system alerts and report updates are stored here.</p>

            <div class="notification-list">
                @forelse ($notifications as $notification)
                    <a href="{{ route('dashboard.notifications.show', $notification->id) }}" class="notification-row {{ $notification->status === 'unread' ? 'notification-row--unread' : '' }}">
                        <div class="notification-row__icon">
                            <i class="bi bi-bell"></i>
                        </div>
                        <div>
                            <strong>{{ $notification->metadata['title'] ?? $notification->subject_name ?? 'Notification' }}</strong>
                            <span>{{ $notification->description }}</span>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-bell fs-3 d-block mb-2"></i>
                        No notifications yet.
                    </div>
                @endforelse
            </div>

            @if (method_exists($notifications, 'links'))
                {{ $notifications->links() }}
            @endif
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .notification-page-card {
            background: #ffffff;
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.14);
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.04);
        }
        .notification-list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .notification-row {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
            text-decoration: none;
            transition: border-color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
        }
        .notification-row:hover {
            background: var(--color-primary-50);
            border-color: var(--color-primary-200);
            transform: translateY(-1px);
        }
        .notification-row--unread {
            background: var(--color-primary-50);
            border-color: var(--color-primary-200);
        }
        .notification-row__icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-primary-600);
            background: var(--color-primary-50);
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.12);
        }
        .notification-row strong,
        .notification-row span,
        .notification-row small {
            display: block;
        }
        .notification-row strong {
            color: #111827;
        }
        .notification-row span,
        .notification-row small {
            color: var(--color-slate-500);
        }
    </style>
@endpush

