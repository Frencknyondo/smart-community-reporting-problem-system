@extends('layouts.app')

@section('title', 'Smart Community Problem Reporting System')

@push('critical-head')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <style>
        .hero-section {
            padding: 120px 0;
            background: linear-gradient(135deg, #ffffff 0%, var(--color-primary-50) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: radial-gradient(circle at center, rgba(var(--color-primary-500-rgb), 0.08) 0%, transparent 70%);
        }

        .home-hero-title {
            font-size: 4rem;
            line-height: 1.08;
        }

        .home-hero-copy {
            max-width: 600px;
            font-size: 1.25rem;
            line-height: 1.65;
        }

        .home-hero-actions {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 1rem;
        }

        .feature-card {
            background: white;
            padding: 24px;
            border-radius: 24px;
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.14);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border-color: var(--color-primary-500);
        }

        .icon-circle {
            width: 48px;
            height: 48px;
            background: var(--color-primary-50);
            color: var(--color-primary-600);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin: 0 auto 16px;
            transition: all 0.3s ease;
        }

        .feature-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.1rem;
        }

        .hero-feature-item {
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid transparent;
            background: transparent;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .hero-feature-item:hover,
        .hero-feature-item:focus-within {
            background: var(--color-primary-50);
            border-color: var(--color-primary-200);
            transform: translateX(8px);
            box-shadow: 0 14px 28px rgba(var(--color-primary-600-rgb), 0.14);
        }

        .hero-feature-item:hover {
            background: var(--color-primary-50);
            border-color: var(--color-primary-200);
            transform: translateX(8px);
            box-shadow: 0 14px 28px rgba(var(--color-primary-600-rgb), 0.14);
        }

        .hero-feature-item .feature-item-icon {
            background: var(--color-primary-50);
            color: var(--color-primary-600);
            transition: all 0.25s ease;
        }

        .hero-feature-item:hover .feature-item-icon,
        .hero-feature-item:focus-within .feature-item-icon {
            background: var(--color-primary-600);
            color: #ffffff;
            transform: scale(1.08);
        }

        .hero-feature-item span {
            transition: color 0.25s ease;
        }

        .hero-feature-item:hover span,
        .hero-feature-item:focus-within span {
            color: var(--color-primary-600);
        }

        .btn-premium {
            padding: 16px 32px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tech-pill {
            display: inline-block;
            padding: 6px 16px;
            background: var(--color-primary-50);
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--color-slate-500);
            margin: 4px;
        }

        .stack-usage-section {
            background: #f8fafc;
            border-top: 1px solid rgba(var(--color-primary-500-rgb), 0.12);
        }

        .stack-usage-card {
            height: 100%;
            padding: 22px;
            background: #ffffff;
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.14);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .stack-usage-card:hover {
            transform: translateY(-4px);
            border-color: var(--color-primary-500);
            box-shadow: 0 18px 35px rgba(15, 23, 42, 0.07);
        }

        .stack-usage-icon {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--color-primary-50);
            color: var(--color-primary-600);
            font-size: 1.15rem;
            margin-bottom: 14px;
        }

        .stack-usage-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(var(--color-primary-500-rgb), 0.1);
            color: var(--color-primary-700);
            font-size: 0.82rem;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .hero-logo-card {
            min-height: 360px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 0 !important;
        }

        .home-hero-map {
            width: 100%;
            height: 420px;
            min-height: 360px;
            display: block;
        }

        .home-map-popup strong {
            display: block;
            color: #111827;
            margin-bottom: 2px;
        }

        .home-map-popup span {
            display: block;
            color: #64748b;
            font-size: 0.82rem;
        }

        .home-section-title {
            font-size: 2rem;
            line-height: 1.2;
        }

        .stack-usage-card h4 {
            font-size: 1.25rem;
            line-height: 1.25;
        }

        .stack-usage-card p {
            font-size: 0.95rem;
            line-height: 1.65;
        }

        .report-step-card,
        .recent-report-card,
        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(var(--color-primary-500-rgb), 0.14);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.05);
        }

        .report-step-card {
            padding: 24px;
        }

        .report-step-card h4,
        .recent-report-card h5,
        .stat-card h3 {
            font-weight: 700;
        }

        .report-step-card p,
        .recent-report-card p,
        .stat-card p {
            color: var(--color-slate-600);
            margin-bottom: 0;
        }

        .stat-card {
            padding: 28px;
            background: rgba(var(--color-primary-500-rgb), 0.08);
            border-color: rgba(var(--color-primary-500-rgb), 0.16);
        }

        .stat-number {
            font-size: 1.85rem;
            line-height: 1;
            font-weight: 800;
            color: var(--color-primary-700);
        }

        @media (max-width: 575.98px) {
            .stat-number {
                font-size: 1.4rem;
            }
        }

        .recent-report-card {
            padding: 18px;
            margin-bottom: 1rem;
        }

        .recent-report-time {
            color: #64748b;
            font-size: 0.92rem;
        }

        .footer-dark {
            background: #111827;
            color: #e5e7eb;
        }

        .footer-dark a {
            color: #f8fafc;
            text-decoration: none;
        }

        .footer-dark a:hover {
            text-decoration: underline;
        }

        .footer-dark .footer-link-title {
            font-weight: 700;
            margin-bottom: 16px;
        }

        .footer-dark .footer-note {
            color: #94a3b8;
            font-size: 0.92rem;
        }

        @media (max-width: 991.98px) {
            .hero-section {
                padding: 88px 0;
            }

            .home-hero-title {
                font-size: 3rem;
            }

            .home-hero-copy {
                max-width: 100%;
                font-size: 1.08rem;
            }

            .home-section-title {
                font-size: 1.75rem;
            }

            .hero-logo-card {
                min-height: 280px;
                margin-top: 2rem;
                padding: 2rem !important;
            }

            .home-hero-map {
                height: 340px;
                min-height: 280px;
            }
        }

        @media (max-width: 575.98px) {
            .hero-section {
                padding: 64px 0 54px;
            }

            .hero-section::before {
                width: 70%;
                opacity: 0.7;
            }

            .home-hero-title {
                font-size: 2.2rem;
                line-height: 1.12;
                margin-bottom: 1rem !important;
            }

            .home-hero-copy {
                font-size: 0.98rem;
                line-height: 1.62;
                margin-bottom: 1.5rem !important;
            }

            .home-hero-actions {
                width: 100%;
                gap: 0.55rem;
            }

            .home-hero-actions .btn-premium {
                flex: 1 1 0;
                min-width: 0;
                padding: 0.75rem 0.55rem;
                border-radius: 10px;
                font-size: 0.78rem;
                line-height: 1.2;
            }

            .home-hero-actions .btn-premium i {
                margin-left: 0.25rem !important;
                margin-right: 0.25rem !important;
            }

            .hero-logo-card {
                min-height: 220px;
                margin-top: 1.6rem;
                border-radius: 18px !important;
            }

            .home-hero-map {
                height: 280px;
                min-height: 220px;
            }

            .tech-pill {
                padding: 5px 12px;
                font-size: 0.78rem;
            }

            .stack-usage-section {
                padding-top: 2.4rem !important;
                padding-bottom: 2.4rem !important;
            }

            .stack-usage-section .container {
                padding-top: 0.5rem !important;
                padding-bottom: 0.5rem !important;
            }

            .home-section-title {
                font-size: 1.45rem;
            }

            .stack-usage-card {
                padding: 18px;
            }

            .stack-usage-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .stack-usage-card h4 {
                font-size: 1.08rem;
            }

            .stack-usage-card p {
                font-size: 0.88rem;
                line-height: 1.58;
            }

            .stack-usage-label {
                font-size: 0.74rem;
                padding: 6px 11px;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="home-hero-title fw-bold mb-4">Smart Community Problem Reporting System</h1>
                    <p class="home-hero-copy text-muted mb-5">
                        Report community issues quickly and transparently. Submit potholes, illegal dumping, broken streetlights,
                        and other neighborhood problems in one easy place.
                    </p>
                    <div class="home-hero-actions justify-content-center justify-content-lg-start">
                        <a href="{{ route('report.start') }}" class="btn btn-primary btn-premium shadow-lg">
                            Report an Issue <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        <a href="/about" class="btn btn-outline-primary btn-premium">
                            Learn More <i class="bi bi-info-circle ms-2"></i>
                        </a>
                    </div>

                    <div class="mt-5">
                        <div class="tech-pill">Community Reports</div>
                        <div class="tech-pill">Track Progress</div>
                        <div class="tech-pill">Safe Submission</div>
                        <div class="tech-pill">Local Action</div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-logo-card bg-white rounded-4 shadow-sm border">
                        <div id="home-hero-map" class="home-hero-map" aria-label="Smart Community issue map"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stack-usage-section home-how-helps-section py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="stack-usage-label">
                        <i class="bi bi-layers"></i>
                        How It Helps
                    </span>
                    <h2 class="home-section-title fw-bold mb-3">What Smart Community Problem Reporting System Delivers</h2>
                    <p class="text-muted mb-lg-0">
                        A modern digital platform that enables citizens to report community problems, track issue progress, and improve communication between the public and local authorities.
                    </p>
                    <p class="text-muted mt-3">
                        The system helps communities respond faster to public issues such as potholes, broken streetlights, flooding, garbage dumping, drainage problems, and damaged infrastructure.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="{{ route('about') }}" class="btn btn-outline-primary px-4">
                        Learn More <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="stack-usage-section py-5 bg-white">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="report-step-card">
                        <span class="stack-usage-label">
                            <i class="bi bi-geo-alt"></i>
                            How to report a problem
                        </span>
                        <div class="mt-3">
                            <p class="mb-3"><strong>1.</strong> Enter a nearby UK postcode, or street name and area</p>
                            <p class="mb-3"><strong>2.</strong> Locate the problem on a map of the area</p>
                            <p class="mb-3"><strong>3.</strong> Enter details of the problem</p>
                            <p class="mb-0"><strong>4.</strong> We send it to the council on your behalf</p>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number">23,271</div>
                                <p class="mb-0">reports in past week</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number">59,495</div>
                                <p class="mb-0">fixed in past month</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-card text-center">
                                <div class="stat-number">15,195,828</div>
                                <p class="mb-0">updates on reports</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="recent-report-card">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0">Recently reported problems</h5>
                            <span class="text-muted">Live feed</span>
                        </div>
                        <div class="mb-3">
                            <strong>More GCC flytipping</strong>
                            <p class="mb-1">Beith Street, Partickhill, Partick, Glasgow, Glasgow City, Alba / Scotland, G11 6QP, United Kingdom.</p>
                            <div class="recent-report-time">17:00 today</div>
                        </div>
                        <div class="mb-3">
                            <strong>Anti social parking on the downs</strong>
                            <p class="mb-1">Circular Road, Sneyd Park, Bristol, City of Bristol, West of England, England, BS9 1NE, United Kingdom.</p>
                            <div class="recent-report-time">16:59 today</div>
                        </div>
                        <div class="mb-3">
                            <strong>Flytipping outside 66 Fingal Street again</strong>
                            <p class="mb-1">Room 1, 66, Fingal Street, Greenwich, SE10 0JJ.</p>
                            <div class="recent-report-time">16:59 today</div>
                        </div>
                        <div class="mb-3">
                            <strong>Metal BBQ dumped on Park Rd Isleworth</strong>
                            <p class="mb-1">Park Road, Spring Grove, London Borough of Hounslow, Greater London, England, TW7 6AE, United Kingdom.</p>
                            <div class="recent-report-time">16:58 today</div>
                        </div>
                        <div>
                            <strong>Bed bases</strong>
                            <p class="mb-1">Roshni Ghar West, Woodborough Street, Baptist Mills, Easton, Bristol, City of Bristol, West of England, England, BS5 0JD, United Kingdom.</p>
                            <div class="recent-report-time">16:57 today</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="stack-usage-section py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-end mb-4">
                <div class="col-lg-7">
                    <span class="stack-usage-label">
                        <i class="bi bi-box-seam"></i>
                        Core Features
                    </span>
                    <h2 class="home-section-title fw-bold mb-3">Built for Community Issue Reporting</h2>
                    <p class="text-muted mb-lg-0">
                        Essential reporting tools, real-time updates, and citizen-focused features designed to support local governance.
                    </p>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <a href="/login" class="btn btn-outline-primary px-4">
                        Get Started <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-list-task"></i></div>
                        <h4 class="fw-bold mb-2">Issue Tracking System</h4>
                        <p class="text-muted mb-0">
                            Track reported problems through different stages such as Open, In Progress, and Resolved with real-time updates.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-geo-alt"></i></div>
                        <h4 class="fw-bold mb-2">Interactive Maps</h4>
                        <p class="text-muted mb-0">
                            Allows users to pinpoint exact problem locations using Google Maps or OpenStreetMap integration.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-people"></i></div>
                        <h4 class="fw-bold mb-2">Community Engagement</h4>
                        <p class="text-muted mb-0">
                            Citizens can support reports through upvotes, comments, and shared community feedback to increase issue visibility.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-bell"></i></div>
                        <h4 class="fw-bold mb-2">Notifications & Alerts</h4>
                        <p class="text-muted mb-0">
                            Receive instant Email or SMS notifications whenever the status of a reported issue changes.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-bar-chart"></i></div>
                        <h4 class="fw-bold mb-2">Analytics Dashboard</h4>
                        <p class="text-muted mb-0">
                            Provides statistics, charts, and reports to help authorities monitor community issues and improve decision-making.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="stack-usage-card">
                        <div class="stack-usage-icon"><i class="bi bi-camera"></i></div>
                        <h4 class="fw-bold mb-2">Media Upload Support</h4>
                        <p class="text-muted mb-0">
                            Users can upload images and videos as evidence to help authorities understand issues more clearly.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

   


@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mapElement = document.getElementById('home-hero-map');
            if (!mapElement || typeof L === 'undefined') return;

            const center = [{{ config('map.default_center.lat') }}, {{ config('map.default_center.lng') }}];
            const map = L.map(mapElement, {
                zoomControl: false,
                scrollWheelZoom: false
            }).setView(center, {{ config('map.default_zoom') }});

            L.tileLayer(@js(config('map.tiles.url')), {
                attribution: @js(config('map.tiles.attribution')),
                minZoom: {{ config('map.min_zoom') }},
                maxZoom: {{ config('map.max_zoom') }}
            }).addTo(map);

            L.control.zoom({ position: 'bottomright' }).addTo(map);

            const points = [
                {
                    lat: center[0],
                    lng: center[1],
                    title: 'Community Report Center',
                    text: 'Click Report an Issue to submit a public problem.'
                },
                {
                    lat: center[0] + 0.018,
                    lng: center[1] - 0.021,
                    title: 'Road Issue',
                    text: 'Example pothole report location.'
                },
                {
                    lat: center[0] - 0.016,
                    lng: center[1] + 0.024,
                    title: 'Flooding Alert',
                    text: 'Example drainage and flooding location.'
                }
            ];

            const bounds = [];
            points.forEach(function (point) {
                bounds.push([point.lat, point.lng]);
                L.marker([point.lat, point.lng])
                    .addTo(map)
                    .bindPopup(`<div class="home-map-popup"><strong>${point.title}</strong><span>${point.text}</span></div>`);
            });

            map.fitBounds(bounds, { padding: [34, 34], maxZoom: 13 });
            setTimeout(function () {
                map.invalidateSize();
            }, 250);
        });
    </script>
@endpush

