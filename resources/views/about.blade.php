@extends('layouts.app')

@section('title', 'About Smart Community Problem Reporting System')

@push('critical-head')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
    <section class="about-page">
        <div class="container">
            <div class="row g-4 align-items-stretch mb-4">
                <div class="col-lg-12">
                    <div class="about-hero-card h-100">
                        <span class="about-kicker"><i class="bi bi-stars"></i> About Smart Community</span>
                        <h1 class="about-title">Making Communities Better Through Reporting</h1>
                        <p class="about-copy">
                            Smart Community Problem Reporting System empowers residents to report community issues quickly and safely. Users can submit
                            issues like potholes, illegal dumping, broken streetlights, and other public hazards — then track the status of their
                            reports as local authorities respond.
                        </p>
                        <ul class="about-list">
                            <li><i class="bi bi-check-circle-fill"></i><span>Easy, mobile-friendly reporting with optional photo and location.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Anonymous reports supported where appropriate to protect privacy.</span></li>
                            <li><i class="bi bi-check-circle-fill"></i><span>Status updates and tracking to see progress from submission to resolution.</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <h2 class="about-section-title mb-0">Transforming Public Service Reporting</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
                    <i class="bi bi-arrow-left me-1"></i>Back to Home
                </a>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-chat-dots"></i></span>
                        <h3>Faster Communication</h3>
                        <p>Bridge the gap between citizens and government agencies instantly.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-building-gear"></i></span>
                        <h3>Better City Management</h3>
                        <p>Help authorities identify critical issues using real-time community data.</p>
                    </article>
                </div>
                <div class="col-md-4">
                    <article class="about-value-card">
                        <span class="about-value-icon"><i class="bi bi-heart-pulse"></i></span>
                        <h3>Safer & Cleaner Communities</h3>
                        <p>Promote healthier environments through active citizen participation.</p>
                    </article>
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <article class="about-mission-card p-4 bg-white rounded-3">
                        <h2 class="about-section-title">Our Mission & How It Works</h2>
                        <p>
                            Our mission is to make civic reporting simple and transparent. Residents can pinpoint issues using their phone or
                            desktop, attach photos, and submit details to the appropriate local authority. Each report receives a tracking ID so
                            reporters can follow progress until resolution.
                        </p>
                        <h3 class="mt-3">How it works</h3>
                        <ol>
                            <li><strong>Spot a problem:</strong> Identify the issue and optionally take a photo.</li>
                            <li><strong>Report it:</strong> Fill a short form with location and description, then submit anonymously or with contact details.</li>
                            <li><strong>Track progress:</strong> Receive updates as the responsible department acknowledges and resolves the issue.</li>
                        </ol>
                        <p class="mb-0">We partner with local authorities to streamline responses and improve community outcomes through timely, verifiable reports.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection

