@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="admin-dashboard px-3 px-lg-4 py-4">
        <section class="admin-welcome">
            <div class="admin-welcome__content">
                <span class="admin-kicker"><i class="bi bi-shield-check"></i> Administrator Control Center</span>
                <h2>Admin Dashboard</h2>
                <p>{{ auth()->user()->full_name }} ame-login kama Admin.</p>
            </div>
            <div class="admin-welcome__meta">
                <span>{{ $resolutionPercent }}%</span>
                <small>Issue resolution rate</small>
            </div>
        </section>

        <section class="admin-stat-grid" aria-label="Admin dashboard statistics">
            @foreach ($stats as $stat)
                <a href="{{ $stat['route'] }}" class="admin-stat-card admin-stat-card--{{ $stat['tone'] }}">
                    <div class="admin-stat-icon"><i class="bi {{ $stat['icon'] }}"></i></div>
                    <div>
                        <span>{{ $stat['label'] }}</span>
                        <strong>{{ number_format($stat['value']) }}</strong>
                        <small>{{ $stat['detail'] }}</small>
                    </div>
                </a>
            @endforeach
        </section>

        <section class="admin-shortcut-grid" aria-label="Admin shortcuts">
            @foreach ($shortcuts as $shortcut)
                <a href="{{ $shortcut['route'] }}" class="admin-shortcut-card">
                    <i class="bi {{ $shortcut['icon'] }}"></i>
                    <div>
                        <strong>{{ $shortcut['label'] }}</strong>
                        <span>{{ $shortcut['detail'] }}</span>
                    </div>
                    <i class="bi bi-arrow-right-short"></i>
                </a>
            @endforeach
        </section>

        <section class="admin-dashboard-grid">
            <article class="admin-panel admin-status-panel">
                <div class="admin-panel-header">
                    <div>
                        <h3>Reported Issues Status</h3>
                        <p>Dotted graph showing solved, pending, and in-progress reports.</p>
                    </div>
                    <span class="admin-panel-badge">{{ number_format($unreadNotifications) }} unread</span>
                </div>

                <div class="admin-dotted-chart">
                    @foreach ($statusBreakdown as $status)
                        <div class="admin-dot-row admin-dot-row--{{ $status['tone'] }}" style="--dot-width: {{ max($status['percent'], $status['count'] > 0 ? 8 : 0) }}%;">
                            <div class="admin-dot-row__label">
                                <span>{{ $status['label'] }}</span>
                                <strong>{{ number_format($status['count']) }}</strong>
                            </div>
                            <div class="admin-dot-row__track">
                                <span></span>
                            </div>
                            <small>{{ $status['percent'] }}%</small>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="admin-panel">
                <div class="admin-panel-header">
                    <div>
                        <h3>Recent Reports</h3>
                        <p>Latest citizen issues submitted to the system.</p>
                    </div>
                    <a href="{{ route('dashboard.reports.index') }}" class="admin-text-link">View all</a>
                </div>

                <div class="admin-report-list">
                    @forelse ($recentReports as $report)
                        <div class="admin-report-row">
                            <div class="admin-report-icon">
                                <i class="bi {{ $report->category?->icon ?? 'bi-exclamation-circle' }}"></i>
                            </div>
                            <div>
                                <strong>{{ $report->title }}</strong>
                                <span>{{ $report->location }} &middot; {{ $report->created_at->format('M d, Y') }}</span>
                            </div>
                            <span class="admin-status-pill admin-status-pill--{{ str_replace('_', '-', $report->status) }}">
                                {{ str_replace('_', ' ', ucfirst($report->status)) }}
                            </span>
                        </div>
                    @empty
                        <div class="admin-empty-state">
                            <i class="bi bi-inbox"></i>
                            <strong>No reports yet</strong>
                            <span>Submitted issues will appear here.</span>
                        </div>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .admin-dashboard {
            color: #111827;
        }

        .admin-welcome,
        .admin-stat-card,
        .admin-shortcut-card,
        .admin-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.04);
        }

        .admin-welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.4rem;
            margin-bottom: 1rem;
        }

        .admin-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.6rem;
            color: var(--color-primary-600);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .admin-welcome h2,
        .admin-panel h3 {
            margin: 0;
            font-weight: 800;
            letter-spacing: 0;
        }

        .admin-welcome h2 {
            font-size: clamp(1.7rem, 2.8vw, 2.5rem);
        }

        .admin-welcome p,
        .admin-panel p {
            margin: 0.35rem 0 0;
            color: var(--color-slate-500);
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .admin-welcome__meta {
            width: 132px;
            min-height: 104px;
            display: grid;
            place-items: center;
            text-align: center;
            border-radius: 14px;
            background: var(--color-primary-50);
            border: 1px solid var(--color-primary-200);
            color: var(--color-primary-600);
            flex-shrink: 0;
            padding: 1rem;
        }

        .admin-welcome__meta span {
            display: block;
            font-size: 2rem;
            line-height: 1;
            font-weight: 900;
        }

        .admin-welcome__meta small {
            display: block;
            margin-top: 0.35rem;
            color: var(--color-slate-500);
            font-size: 0.76rem;
            line-height: 1.35;
        }

        .admin-stat-grid,
        .admin-shortcut-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .admin-stat-card,
        .admin-shortcut-card {
            text-decoration: none;
            color: inherit;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .admin-stat-card:hover,
        .admin-shortcut-card:hover {
            transform: translateY(-2px);
            border-color: rgba(var(--color-primary-500-rgb), 0.34);
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.08);
        }

        .admin-stat-card {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 1rem;
        }

        .admin-stat-icon,
        .admin-shortcut-card > i:first-child,
        .admin-report-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-primary-600);
            background: var(--color-primary-50);
            font-size: 1.1rem;
        }

        .admin-stat-card--success .admin-stat-icon {
            color: var(--color-success-700);
            background: rgba(var(--color-success-500-rgb), 0.12);
        }

        .admin-stat-card--warning .admin-stat-icon {
            color: var(--color-warning-700);
            background: rgba(var(--color-warning-500-rgb), 0.14);
        }

        .admin-stat-card--info .admin-stat-icon {
            color: var(--color-info-500);
            background: rgba(var(--color-info-500-rgb), 0.12);
        }

        .admin-stat-card span,
        .admin-stat-card small,
        .admin-shortcut-card span {
            display: block;
            color: var(--color-slate-500);
            font-size: 0.78rem;
        }

        .admin-stat-card strong {
            display: block;
            font-size: 1.65rem;
            line-height: 1.1;
            color: #111827;
        }

        .admin-shortcut-card {
            min-height: 98px;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 1rem;
        }

        .admin-shortcut-card div {
            min-width: 0;
            flex: 1 1 auto;
        }

        .admin-shortcut-card strong {
            display: block;
            color: #111827;
            font-size: 0.94rem;
        }

        .admin-shortcut-card > i:last-child {
            color: var(--color-primary-600);
            font-size: 1.35rem;
        }

        .admin-dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.25fr);
            gap: 1rem;
        }

        .admin-panel {
            padding: 1rem;
        }

        .admin-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .admin-panel h3 {
            font-size: 1.05rem;
        }

        .admin-panel-badge {
            border-radius: 999px;
            padding: 0.36rem 0.7rem;
            background: rgba(var(--color-primary-500-rgb), 0.1);
            color: var(--color-primary-600);
            font-size: 0.76rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .admin-dotted-chart,
        .admin-report-list {
            display: grid;
            gap: 0.8rem;
        }

        .admin-dot-row {
            display: grid;
            grid-template-columns: minmax(126px, 0.55fr) minmax(140px, 1fr) 44px;
            align-items: center;
            gap: 0.85rem;
        }

        .admin-dot-row__label span,
        .admin-dot-row small {
            display: block;
            color: var(--color-slate-500);
            font-size: 0.78rem;
        }

        .admin-dot-row__label strong {
            display: block;
            color: #111827;
            font-size: 1.05rem;
            line-height: 1.1;
        }

        .admin-dot-row__track {
            position: relative;
            height: 14px;
            border-radius: 999px;
            background-image: radial-gradient(circle, #cbd5e1 2px, transparent 2.6px);
            background-size: 14px 14px;
            overflow: hidden;
        }

        .admin-dot-row__track span {
            display: block;
            width: var(--dot-width);
            height: 100%;
            border-radius: inherit;
            background-image: radial-gradient(circle, var(--dot-color, var(--color-primary-600)) 2.5px, transparent 3.1px);
            background-size: 14px 14px;
        }

        .admin-dot-row--success {
            --dot-color: var(--color-success-700);
        }

        .admin-dot-row--warning {
            --dot-color: var(--color-warning-700);
        }

        .admin-dot-row--info {
            --dot-color: var(--color-info-500);
        }

        .admin-dot-row--danger {
            --dot-color: var(--color-danger-600);
        }

        .admin-text-link {
            color: var(--color-primary-600);
            text-decoration: none;
            font-weight: 800;
            font-size: 0.86rem;
            white-space: nowrap;
        }

        .admin-report-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.82rem;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .admin-report-row > div:nth-child(2) {
            min-width: 0;
            flex: 1 1 auto;
        }

        .admin-report-row strong {
            display: block;
            color: #111827;
            font-size: 0.92rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-report-row span {
            display: block;
            color: var(--color-slate-500);
            font-size: 0.82rem;
            line-height: 1.45;
        }

        .admin-status-pill {
            flex-shrink: 0;
            border-radius: 999px;
            padding: 0.35rem 0.62rem;
            background: rgba(var(--color-danger-500-rgb), 0.1);
            color: var(--color-danger-600) !important;
            font-size: 0.72rem !important;
            font-weight: 800;
            text-transform: capitalize;
        }

        .admin-status-pill--in-progress,
        .admin-status-pill--under-review {
            background: rgba(var(--color-warning-500-rgb), 0.14);
            color: var(--color-warning-700) !important;
        }

        .admin-status-pill--resolved {
            background: rgba(var(--color-success-500-rgb), 0.12);
            color: var(--color-success-700) !important;
        }

        .admin-empty-state {
            min-height: 180px;
            display: grid;
            place-items: center;
            text-align: center;
            gap: 0.35rem;
            color: var(--color-slate-500);
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 1rem;
        }

        .admin-empty-state i {
            color: var(--color-primary-600);
            font-size: 1.5rem;
        }

        .admin-empty-state strong {
            display: block;
            color: #111827;
        }

        @media (max-width: 1199.98px) {
            .admin-stat-grid,
            .admin-shortcut-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .admin-dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .admin-welcome,
            .admin-report-row {
                align-items: stretch;
                flex-direction: column;
            }

            .admin-welcome__meta {
                width: 100%;
                min-height: auto;
            }

            .admin-stat-grid,
            .admin-shortcut-grid {
                grid-template-columns: 1fr;
            }

            .admin-dot-row {
                grid-template-columns: 1fr;
                gap: 0.45rem;
            }

            .admin-status-pill {
                align-self: flex-start;
            }
        }
    </style>
@endpush
