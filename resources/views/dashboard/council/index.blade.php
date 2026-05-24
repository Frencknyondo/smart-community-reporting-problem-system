@extends('layouts.frankDashboardLayout')

@section('content')
    <section class="role-dashboard role-dashboard--council">
        <h1>Council Dashboard</h1>
        <p>{{ auth()->user()->full_name }} ame-login kama Council.</p>
    </section>
@endsection

@push('styles')
    <style>
        .role-dashboard {
            min-height: calc(100vh - 180px);
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            margin: 1.5rem;
            padding: clamp(1.5rem, 4vw, 3rem);
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #111827;
        }

        .role-dashboard h1 {
            margin: 0 0 0.75rem;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
        }

        .role-dashboard p {
            margin: 0;
            color: #4b5563;
            font-size: 1.05rem;
        }
    </style>
@endpush
