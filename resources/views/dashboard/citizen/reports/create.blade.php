@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <form id="report-form" method="POST" action="{{ route('dashboard.citizen.reports.store') }}" enctype="multipart/form-data" class="report-form-grid">
            @csrf

            <section class="report-panel">
                <h2>Report an Issue</h2>
                <p class="text-muted">Fill the issue details, choose the location on the map, or let your device provide your current location.</p>

                @include('auth.partials.feedback')

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label" for="title">Issue Title</label>
                        <input id="title" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Broken Street Light" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="category_id">Issue Category</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="priority">Priority Level</label>
                        <select id="priority" name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                            @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'emergency' => 'Emergency'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('priority', 'medium') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="description">Issue Description</label>
                        <textarea id="description" name="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="Describe the problem clearly..." required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="location">Location</label>
                        <input id="location" name="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror" placeholder="Street, ward, district, nearby landmark, or device current location">
                        <div class="form-text">If you leave this empty and do not click the map, your device will ask permission to use current location on submit.</div>
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="image">Upload Image</label>
                        <input id="image" name="image" type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="video">Upload Video Optional</label>
                        <input id="video" name="video" type="file" accept="video/*" class="form-control @error('video') is-invalid @enderror">
                        @error('video')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous'))>
                            <span class="form-check-label">Report anonymously on public views</span>
                        </label>
                    </div>
                </div>
            </section>

            <section class="report-panel">
                <h2>Choose Location</h2>
                <p class="text-muted">Click the map to set GPS coordinates, or submit without map selection to use current location.</p>
                <div id="report-map"></div>
                <div id="location-status" class="location-status" aria-live="polite"></div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label" for="latitude">Latitude</label>
                        <input id="latitude" name="latitude" value="{{ old('latitude') }}" class="form-control" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="longitude">Longitude</label>
                        <input id="longitude" name="longitude" value="{{ old('longitude') }}" class="form-control" readonly>
                    </div>
                </div>

                <button class="btn btn-primary w-100 mt-4" type="submit">
                    <i class="bi bi-send me-1"></i> Submit Report
                </button>
            </section>
        </form>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        .report-form-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
            gap: 1rem;
        }
        .report-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 1.25rem;
        }
        .report-panel h2 {
            margin: 0 0 0.35rem;
            font-size: 1.35rem;
            font-weight: 800;
        }
        #report-map {
            height: 420px;
            border-radius: 12px;
            border: 1px solid #dbe3ef;
            overflow: hidden;
        }
        .location-status {
            min-height: 1.25rem;
            margin-top: 0.65rem;
            color: var(--color-slate-500);
            font-size: 0.84rem;
        }
        .location-status.is-loading {
            color: var(--color-primary-600);
            font-weight: 700;
        }
        .location-status.is-error {
            color: var(--color-danger-600);
            font-weight: 700;
        }
        @media (max-width: 991.98px) {
            .report-form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('report-form');
            const center = [{{ $mapConfig['default_center']['lat'] }}, {{ $mapConfig['default_center']['lng'] }}];
            const map = L.map('report-map').setView(center, {{ $mapConfig['default_zoom'] }});
            const location = document.getElementById('location');
            const latitude = document.getElementById('latitude');
            const longitude = document.getElementById('longitude');
            const locationStatus = document.getElementById('location-status');
            const submitButton = form.querySelector('button[type="submit"]');
            let marker = null;
            let isLocating = false;

            L.tileLayer(@js($mapConfig['tiles']['url']), {
                attribution: @js($mapConfig['tiles']['attribution']),
                minZoom: {{ $mapConfig['min_zoom'] }},
                maxZoom: {{ $mapConfig['max_zoom'] }}
            }).addTo(map);

            function setMarker(lat, lng, shouldUpdateLocation = false) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng]).addTo(map);
                latitude.value = Number(lat).toFixed(7);
                longitude.value = Number(lng).toFixed(7);

                if (shouldUpdateLocation && !location.value.trim()) {
                    location.value = `Current location (${latitude.value}, ${longitude.value})`;
                }
            }

            function setLocationStatus(message = '', tone = '') {
                locationStatus.textContent = message;
                locationStatus.classList.toggle('is-loading', tone === 'loading');
                locationStatus.classList.toggle('is-error', tone === 'error');
            }

            if (latitude.value && longitude.value) {
                setMarker(latitude.value, longitude.value);
                map.setView([latitude.value, longitude.value], 15);
            }

            map.on('click', function (event) {
                setMarker(event.latlng.lat, event.latlng.lng);
                if (!location.value.trim()) {
                    location.value = `Selected map location (${latitude.value}, ${longitude.value})`;
                }
                setLocationStatus('Map location selected.');
            });

            form.addEventListener('submit', function (event) {
                const hasTypedLocation = location.value.trim().length > 0;
                const hasCoordinates = latitude.value.trim().length > 0 && longitude.value.trim().length > 0;

                if (hasTypedLocation || hasCoordinates || isLocating) {
                    return;
                }

                event.preventDefault();

                if (!navigator.geolocation) {
                    setLocationStatus('Your browser cannot detect current location. Please type location or click the map.', 'error');
                    location.focus();
                    return;
                }

                isLocating = true;
                submitButton.disabled = true;
                setLocationStatus('Getting your current location from this device...', 'loading');

                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    setMarker(lat, lng, true);
                    map.setView([lat, lng], 16);
                    setLocationStatus('Current location detected. Submitting report...', 'loading');
                    form.requestSubmit();
                }, function () {
                    isLocating = false;
                    submitButton.disabled = false;
                    setLocationStatus('Location permission was not allowed. Please type location or click the map before submitting.', 'error');
                    location.focus();
                }, {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 60000
                });
            });
        });
    </script>
@endpush
