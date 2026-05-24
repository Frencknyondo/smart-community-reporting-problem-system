@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="report-panel">
            <h2>Add User</h2>
            <p class="text-muted">Create a user and assign their system role.</p>

            @include('auth.partials.feedback')

            <form method="POST" action="{{ route('dashboard.users.store') }}" class="row g-3">
                @csrf
                @include('dashboard.admin.users.partials.form', ['user' => null])
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Create User</button>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection

@include('dashboard.admin.users.partials.styles')
