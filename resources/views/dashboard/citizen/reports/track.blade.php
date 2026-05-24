@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="report-panel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h2 class="mb-1">Track My Reports</h2>
                    <p class="text-muted mb-0">Monitor the status of your submitted reports and track their progress.</p>
                </div>
            </div>

            <!-- Status Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="card status-card status-card-total">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-muted small">Total Reports</h6>
                                    <h3 class="mb-0 mt-1">{{ $statusCounts['total'] }}</h3>
                                </div>
                                <div class="status-icon">
                                    <i class="bi bi-file-earmark-text-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card status-card status-card-open">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-muted small">Open</h6>
                                    <h3 class="mb-0 mt-1">{{ $statusCounts['open'] }}</h3>
                                </div>
                                <div class="status-icon">
                                    <i class="bi bi-circle-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card status-card status-card-review">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-muted small">Under Review</h6>
                                    <h3 class="mb-0 mt-1">{{ $statusCounts['under_review'] }}</h3>
                                </div>
                                <div class="status-icon">
                                    <i class="bi bi-eye-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card status-card status-card-progress">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0 text-muted small">In Progress</h6>
                                    <h3 class="mb-0 mt-1">{{ $statusCounts['in_progress'] }}</h3>
                                </div>
                                <div class="status-icon">
                                    <i class="bi bi-gear-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Map -->
            <div id="reports-map" class="mb-4"></div>

            <!-- Reports Table -->
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Issue</th>
                            <th>Category</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($report->image_url)
                                            <img src="{{ $report->image_url }}" 
                                                 alt="Report image" 
                                                 style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <span class="report-image-placeholder report-image-placeholder--thumb">
                                                <i class="bi bi-image"></i>
                                            </span>
                                        @endif
                                        <div>
                                            <strong>{{ $report->title }}</strong>
                                            @if($report->is_anonymous)
                                                <span class="badge text-bg-secondary ms-1" style="font-size: 0.65rem;">Anonymous</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge text-bg-light border">{{ $report->category?->name ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    @php
                                        $priorityColors = [
                                            'low' => 'text-bg-success',
                                            'medium' => 'text-bg-warning',
                                            'high' => 'text-bg-danger',
                                            'emergency' => 'text-bg-dark'
                                        ];
                                    @endphp
                                    <span class="badge {{ $priorityColors[$report->priority] ?? 'text-bg-secondary' }}">
                                        {{ ucfirst($report->priority) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'open' => ['class' => 'text-bg-primary', 'label' => 'Open'],
                                            'under_review' => ['class' => 'text-bg-info', 'label' => 'Under Review'],
                                            'in_progress' => ['class' => 'text-bg-warning', 'label' => 'In Progress'],
                                            'resolved' => ['class' => 'text-bg-success', 'label' => 'Resolved']
                                        ];
                                        $config = $statusConfig[$report->status] ?? ['class' => 'text-bg-secondary', 'label' => ucfirst($report->status)];
                                    @endphp
                                    <span class="badge {{ $config['class'] }}">
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        <i class="bi bi-geo-alt me-1"></i>{{ Str::limit($report->location, 25) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div>{{ $report->created_at->format('M d, Y') }}</div>
                                        <div class="text-muted">{{ $report->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" 
                                            onclick="showReportDetails({{ $report->id }}, @js($report->title), @js($report->description), @js($report->location), @js($report->status), @js($report->category?->name), @js($report->image_url))"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#reportDetailsModal">
                                        <i class="bi bi-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <div class="py-4">
                                        <i class="bi bi-inbox display-4 text-muted"></i>
                                        <p class="mt-3 mb-1">No reports submitted yet</p>
                                        <p class="small text-muted">Start by reporting an issue in your community.</p>
                                        <a href="{{ route('dashboard.citizen.reports.create') }}" class="btn btn-primary btn-sm mt-2">
                                            <i class="bi bi-plus-circle me-1"></i> Report an Issue
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $reports->links() }}
            </div>
        </section>
    </div>

    <!-- Report Details Modal -->
    <div class="modal fade" id="reportDetailsModal" tabindex="-1" aria-labelledby="reportDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportDetailsModalLabel">Report Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div id="modalReportImageWrap" class="report-modal-image-wrap">
                                <img id="modalReportImage" src="" alt="Report image">
                            </div>
                            <div id="modalReportNoImage" class="report-modal-no-image">
                                <i class="bi bi-image"></i>
                                <span>No image uploaded for this report.</span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small">Title</h6>
                            <p id="modalReportTitle" class="fw-semibold mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small">Category</h6>
                            <p id="modalReportCategory" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small">Status</h6>
                            <p id="modalReportStatus" class="mb-0">-</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted small">Location</h6>
                            <p id="modalReportLocation" class="mb-0">-</p>
                        </div>
                        <div class="col-12 mb-3">
                            <h6 class="text-muted small">Description</h6>
                            <p id="modalReportDescription" class="mb-0">-</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
        .status-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .status-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        .status-card .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .status-card-total .status-icon {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }
        .status-card-open .status-icon {
            background: rgba(25, 135, 84, 0.1);
            color: #198754;
        }
        .status-card-review .status-icon {
            background: rgba(13, 202, 240, 0.1);
            color: #0dcaf0;
        }
        .status-card-progress .status-icon {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        .status-card-resolved .status-icon {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        .report-image-placeholder {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: #f1f5f9;
            border: 1px dashed #cbd5e1;
            color: #64748b;
        }
        .report-image-placeholder--thumb {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }
        .report-modal-image-wrap {
            display: none;
            width: 100%;
            max-height: 360px;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
        }
        .report-modal-image-wrap img {
            width: 100%;
            max-height: 360px;
            object-fit: contain;
            display: block;
        }
        .report-modal-no-image {
            min-height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 0.45rem;
            border-radius: 12px;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            color: #64748b;
            text-align: center;
        }
        .report-modal-no-image i {
            font-size: 1.6rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        function showReportDetails(id, title, description, location, status, category, imageUrl) {
            document.getElementById('modalReportTitle').textContent = title;
            document.getElementById('modalReportDescription').textContent = description;
            document.getElementById('modalReportLocation').textContent = location;
            document.getElementById('modalReportStatus').textContent = status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.getElementById('modalReportCategory').textContent = category || 'N/A';

            const imageWrap = document.getElementById('modalReportImageWrap');
            const image = document.getElementById('modalReportImage');
            const noImage = document.getElementById('modalReportNoImage');

            if (imageUrl) {
                image.src = imageUrl;
                imageWrap.style.display = 'block';
                noImage.style.display = 'none';
            } else {
                image.removeAttribute('src');
                imageWrap.style.display = 'none';
                noImage.style.display = 'flex';
            }
        }

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
                const statusLabel = report.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                L.marker([report.latitude, report.longitude])
                    .addTo(map)
                    .bindPopup(`<strong>${report.title}</strong><br>${report.location}<br>Status: ${statusLabel}`);
            });
        });
    </script>
@endpush
