@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="citizen-dashboard px-3 px-lg-4 py-4">
        <section class="citizen-welcome">
            <div>
                <span class="citizen-kicker"><i class="bi bi-person-check"></i> Community Contributor Level: Active Citizen</span>
                <h2>Welcome Back, {{ auth()->user()->full_name }}</h2>
                <p>Help improve your community by reporting public issues and tracking council responses.</p>
            </div>
            <a href="{{ route('dashboard.citizen.reports.create') }}" class="btn btn-primary citizen-welcome-btn">
                <i class="bi bi-plus-circle"></i>
                <span>Report New Issue</span>
            </a>
        </section>

        <section class="citizen-stat-grid">
            @foreach ($stats as $stat)
                <article class="citizen-stat-card citizen-stat-card--{{ $stat['tone'] }}">
                    <div class="citizen-stat-icon"><i class="bi {{ $stat['icon'] }}"></i></div>
                    <div>
                        <span>{{ $stat['label'] }}</span>
                        <strong>{{ number_format($stat['value']) }}</strong>
                        <small>{{ $stat['detail'] }}</small>
                    </div>
                </article>
            @endforeach
        </section>

        <section class="citizen-dashboard-grid">
            <div class="citizen-main-stack">
                <article class="citizen-panel">
                    <div class="citizen-panel-header">
                        <div>
                            <h3>My Recent Reports</h3>
                            <p>Track the latest issues you submitted.</p>
                        </div>
                        <a href="{{ route('dashboard.reports.index') }}" class="citizen-text-link">View all</a>
                    </div>

                    <div class="citizen-report-list">
                        @forelse ($recentReports as $report)
                            <div class="citizen-report-row">
                                <div class="citizen-report-icon">
                                    <i class="bi {{ $report->category?->icon ?? 'bi-exclamation-circle' }}"></i>
                                </div>
                                <div>
                                    <strong>{{ $report->title }}</strong>
                                    <span>{{ $report->category?->name }} &middot; {{ $report->created_at->format('M d, Y') }}</span>
                                </div>
                                <span class="citizen-status citizen-status--{{ str_replace('_', '-', $report->status) }}">
                                    {{ str_replace('_', ' ', ucfirst($report->status)) }}
                                </span>
                            </div>
                        @empty
                            <div class="citizen-empty-state">
                                <i class="bi bi-file-earmark-plus"></i>
                                <strong>No reports yet</strong>
                                <span>Submit your first issue to start tracking progress here.</span>
                            </div>
                        @endforelse
                    </div>
                </article>

                <div class="citizen-two-column">
                    <article class="citizen-panel">
                        <div class="citizen-panel-header">
                            <div>
                                <h3>Recent Activity</h3>
                                <p>Updates from your issue journey.</p>
                            </div>
                        </div>
                        <div class="citizen-activity-list">
                            @forelse ($recentReports->take(3) as $report)
                                <div class="citizen-activity-item">
                                    <i class="bi bi-arrow-repeat"></i>
                                    <div>
                                        <strong>{{ $report->title }}</strong>
                                        <span>Status is {{ str_replace('_', ' ', $report->status) }}.</span>
                                    </div>
                                </div>
                            @empty
                                <div class="citizen-activity-item">
                                    <i class="bi bi-info-circle"></i>
                                    <div>
                                        <strong>No activity yet</strong>
                                        <span>Your report updates will appear here.</span>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </article>

                    <article class="citizen-panel citizen-impact-panel">
                        <div class="citizen-panel-header">
                            <div>
                                <h3>Community Impact</h3>
                                <p>Your contribution so far.</p>
                            </div>
                        </div>
                        <div class="citizen-impact-number">{{ number_format($resolvedCount) }}</div>
                        <p class="mb-3">community issues helped toward resolution through your reports.</p>
                        <div class="citizen-progress-label">
                            <span>Issue Resolution Progress</span>
                            <strong>{{ $stats[0]['value'] > 0 ? round(($resolvedCount / max($stats[0]['value'], 1)) * 100) : 0 }}%</strong>
                        </div>
                        <div class="citizen-progress">
                            <span style="width: {{ $stats[0]['value'] > 0 ? round(($resolvedCount / max($stats[0]['value'], 1)) * 100) : 0 }}%"></span>
                        </div>
                    </article>
                </div>

                <article class="citizen-panel">
                    <div class="citizen-panel-header">
                        <div>
                            <h3>Quick Actions</h3>
                            <p>Common citizen tasks in one place.</p>
                        </div>
                    </div>
                    <div class="citizen-action-grid">
                        <a href="{{ route('dashboard.citizen.reports.create') }}"><i class="bi bi-plus-circle"></i><span>Report Issue</span></a>
                        <a href="#citizen-map"><i class="bi bi-map"></i><span>View Map</span></a>
                        <a href="{{ route('dashboard.reports.index') }}"><i class="bi bi-list-check"></i><span>Track Reports</span></a>
                        <a href="#"><i class="bi bi-telephone"></i><span>Emergency Contacts</span></a>
                    </div>
                </article>
            </div>

            <aside class="citizen-side-stack">
                <article class="citizen-panel" id="citizen-map">
                    <div class="citizen-panel-header">
                        <div>
                            <h3>Issue Map</h3>
                            <p>Your reports and selected locations.</p>
                        </div>
                    </div>
                    <div id="citizen-dashboard-map"></div>
                </article>

                <article class="citizen-panel">
                    <div class="citizen-panel-header">
                        <div>
                            <h3>Notifications</h3>
                            <p>Latest report messages.</p>
                        </div>
                    </div>
                    <div class="citizen-activity-list">
                        <div class="citizen-activity-item">
                            <i class="bi bi-bell"></i>
                            <div>
                                <strong>Council responses</strong>
                                <span>Responses to your reports will appear here.</span>
                            </div>
                        </div>
                        <div class="citizen-activity-item">
                            <i class="bi bi-hand-thumbs-up"></i>
                            <div>
                                <strong>Community supports</strong>
                                <span>Support updates will be shown once voting is enabled.</span>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="citizen-panel">
                    <div class="citizen-panel-header">
                        <div>
                            <h3>Nearby Community Alerts</h3>
                            <p>High priority reports near the community.</p>
                        </div>
                    </div>
                    <div class="citizen-alert-list">
                        @forelse ($nearbyAlerts as $alert)
                            <div class="citizen-alert-item">
                                <i class="bi bi-exclamation-triangle"></i>
                                <span>{{ $alert->title }} at {{ $alert->location }}</span>
                            </div>
                        @empty
                            <div class="citizen-alert-item">
                                <i class="bi bi-shield-check"></i>
                                <span>No high priority nearby alerts right now.</span>
                            </div>
                        @endforelse
                    </div>
                </article>

                <article class="citizen-tip-panel">
                    <i class="bi bi-lightbulb"></i>
                    <div>
                        <strong>Tip</strong>
                        <span>Upload clear photos to help councils respond faster.</span>
                    </div>
                </article>
            </aside>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .citizen-dashboard {
            color: #111827;
        }

        .citizen-welcome,
        .citizen-panel,
        .citizen-stat-card,
        .citizen-tip-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.04);
        }

        .citizen-welcome {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.35rem;
            margin-bottom: 1rem;
        }

        .citizen-kicker {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            margin-bottom: 0.6rem;
            color: var(--color-primary-600);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .citizen-welcome h2,
        .citizen-panel h3 {
            margin: 0;
            font-weight: 800;
        }

        .citizen-welcome h2 {
            font-size: clamp(1.55rem, 2.6vw, 2.2rem);
        }

        .citizen-welcome p,
        .citizen-panel p {
            margin: 0.35rem 0 0;
            color: var(--color-slate-500);
            font-size: 0.92rem;
            line-height: 1.55;
        }

        .citizen-welcome-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            white-space: nowrap;
        }

        .citizen-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .citizen-stat-card {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 1rem;
        }

        .citizen-stat-icon {
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

        .citizen-stat-card--success .citizen-stat-icon {
            color: var(--color-success-700);
            background: rgba(var(--color-success-500-rgb), 0.12);
        }

        .citizen-stat-card--warning .citizen-stat-icon {
            color: var(--color-warning-700);
            background: rgba(var(--color-warning-500-rgb), 0.14);
        }

        .citizen-stat-card--info .citizen-stat-icon {
            color: var(--color-info-500);
            background: rgba(var(--color-info-500-rgb), 0.12);
        }

        .citizen-stat-card span,
        .citizen-stat-card small {
            display: block;
            color: var(--color-slate-500);
            font-size: 0.78rem;
        }

        .citizen-stat-card strong {
            display: block;
            font-size: 1.6rem;
            line-height: 1.1;
            color: #111827;
        }

        .citizen-dashboard-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(330px, 0.9fr);
            gap: 1rem;
        }

        .citizen-main-stack,
        .citizen-side-stack {
            display: grid;
            gap: 1rem;
            align-content: start;
        }

        .citizen-two-column {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .citizen-panel {
            padding: 1rem;
        }

        .citizen-panel-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .citizen-panel h3 {
            font-size: 1.05rem;
        }

        .citizen-text-link {
            color: var(--color-primary-600);
            text-decoration: none;
            font-weight: 700;
            font-size: 0.86rem;
            white-space: nowrap;
        }

        .citizen-report-list,
        .citizen-activity-list,
        .citizen-alert-list {
            display: grid;
            gap: 0.75rem;
        }

        .citizen-report-row,
        .citizen-activity-item,
        .citizen-alert-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.8rem;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #e5e7eb;
        }

        .citizen-report-icon,
        .citizen-activity-item > i,
        .citizen-alert-item > i {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-primary-600);
            background: var(--color-primary-50);
        }

        .citizen-report-row > div:nth-child(2),
        .citizen-activity-item > div {
            min-width: 0;
            flex: 1 1 auto;
        }

        .citizen-report-row strong,
        .citizen-activity-item strong {
            display: block;
            color: #111827;
            font-size: 0.92rem;
        }

        .citizen-report-row span,
        .citizen-activity-item span,
        .citizen-alert-item span,
        .citizen-tip-panel span {
            display: block;
            color: var(--color-slate-500);
            font-size: 0.82rem;
            line-height: 1.45;
        }

        .citizen-status {
            flex-shrink: 0;
            border-radius: 999px;
            padding: 0.35rem 0.62rem;
            background: rgba(var(--color-danger-500-rgb), 0.1);
            color: var(--color-danger-600);
            font-size: 0.72rem !important;
            font-weight: 800;
            text-transform: capitalize;
        }

        .citizen-status--in-progress,
        .citizen-status--under-review {
            background: rgba(var(--color-warning-500-rgb), 0.14);
            color: var(--color-warning-700);
        }

        .citizen-status--resolved {
            background: rgba(var(--color-success-500-rgb), 0.12);
            color: var(--color-success-700);
        }

        .citizen-impact-number {
            font-size: 2.4rem;
            line-height: 1;
            font-weight: 900;
            color: var(--color-primary-600);
        }

        .citizen-progress-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            color: var(--color-slate-600);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .citizen-progress {
            height: 10px;
            margin-top: 0.5rem;
            border-radius: 999px;
            background: var(--color-primary-50);
            overflow: hidden;
        }

        .citizen-progress span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: var(--color-primary-600);
        }

        .citizen-action-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .citizen-action-grid a {
            min-height: 86px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            border-radius: 12px;
            text-decoration: none;
            color: var(--color-primary-600);
            background: var(--color-primary-50);
            border: 1px solid var(--color-primary-200);
            font-size: 0.84rem;
            font-weight: 700;
            text-align: center;
        }

        .citizen-action-grid i {
            font-size: 1.25rem;
        }

        #citizen-dashboard-map {
            height: 280px;
            border-radius: 12px;
            border: 1px solid #dbe3ef;
            overflow: hidden;
        }

        .citizen-tip-panel {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
        }

        .citizen-tip-panel i {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-warning-700);
            background: rgba(var(--color-warning-500-rgb), 0.14);
        }

        .citizen-tip-panel strong,
        .citizen-empty-state strong {
            display: block;
            color: #111827;
        }

        .citizen-empty-state {
            min-height: 150px;
            display: grid;
            place-items: center;
            text-align: center;
            gap: 0.35rem;
            color: var(--color-slate-500);
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 1rem;
        }

        .citizen-empty-state i {
            color: var(--color-primary-600);
            font-size: 1.5rem;
        }

        @media (max-width: 1199.98px) {
            .citizen-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .citizen-dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .citizen-welcome {
                align-items: stretch;
                flex-direction: column;
            }
            .citizen-two-column,
            .citizen-action-grid,
            .citizen-stat-grid {
                grid-template-columns: 1fr;
            }
            .citizen-report-row {
                align-items: flex-start;
                flex-wrap: wrap;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reports = @json($mapReports);
            const center = [{{ $mapConfig['default_center']['lat'] }}, {{ $mapConfig['default_center']['lng'] }}];
            const map = L.map('citizen-dashboard-map').setView(center, {{ $mapConfig['default_zoom'] }});

            L.tileLayer(@js($mapConfig['tiles']['url']), {
                attribution: @js($mapConfig['tiles']['attribution']),
                minZoom: {{ $mapConfig['min_zoom'] }},
                maxZoom: {{ $mapConfig['max_zoom'] }}
            }).addTo(map);

            const bounds = [];
            reports.forEach(function (report) {
                if (!report.latitude || !report.longitude) return;
                const point = [Number(report.latitude), Number(report.longitude)];
                bounds.push(point);
                L.marker(point)
                    .addTo(map)
                    .bindPopup(`<strong>${report.title}</strong><br>${report.location}`);
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [24, 24], maxZoom: 15 });
            }
        });
    </script>
@endpush
