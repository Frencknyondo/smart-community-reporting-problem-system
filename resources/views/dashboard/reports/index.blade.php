@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="report-panel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h2 class="mb-1">Reported Issues</h2>
                    <p class="text-muted mb-0">Review submitted community reports and their tracking status.</p>
                </div>
            </div>

            <div id="reports-map" class="mb-4"></div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Issue</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Reporter</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($report->image_url)
                                            <img src="{{ $report->image_url }}" alt="Report image" class="report-issue-thumb">
                                        @else
                                            <span class="report-issue-thumb report-issue-thumb--empty">
                                                <i class="bi bi-image"></i>
                                            </span>
                                        @endif
                                        <div>
                                            <strong>{{ $report->title }}</strong>
                                            <div class="text-muted small">{{ $report->location }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $report->category?->name }}</td>
                                <td><span class="badge text-bg-warning">{{ ucfirst($report->priority) }}</span></td>
                                <td>
                                    @if (in_array(auth()->user()->role, ['admin', 'council'], true))
                                        <form method="POST" action="{{ route('dashboard.reports.status.update', $report) }}">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                @foreach (['open' => 'Open', 'under_review' => 'Under Review', 'in_progress' => 'In Progress', 'resolved' => 'Resolved'] as $value => $label)
                                                    <option value="{{ $value }}" @selected($report->status === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </form>
                                    @else
                                        <span class="badge text-bg-primary">{{ str_replace('_', ' ', ucfirst($report->status)) }}</span>
                                    @endif
                                </td>
                                <td>{{ $report->is_anonymous ? 'Anonymous' : $report->reporter?->full_name }}</td>
                                <td>{{ $report->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No reports found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $reports->links() }}
        </section>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        .report-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 1.25rem;
        }
        #reports-map {
            height: 360px;
            border-radius: 12px;
            border: 1px solid #dbe3ef;
            overflow: hidden;
        }
        .report-issue-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            flex-shrink: 0;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
        }
        .report-issue-thumb--empty {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            border-style: dashed;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reports = @json($reports->items());
            const center = [{{ $mapConfig['default_center']['lat'] }}, {{ $mapConfig['default_center']['lng'] }}];
            const map = L.map('reports-map').setView(center, {{ $mapConfig['default_zoom'] }});

            L.tileLayer(@js($mapConfig['tiles']['url']), {
                attribution: @js($mapConfig['tiles']['attribution']),
                minZoom: {{ $mapConfig['min_zoom'] }},
                maxZoom: {{ $mapConfig['max_zoom'] }}
            }).addTo(map);

            reports.forEach(function (report) {
                if (!report.latitude || !report.longitude) return;
                L.marker([report.latitude, report.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${report.title}</strong><br>${report.location}`);
            });
        });
    </script>
@endpush
