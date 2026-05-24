@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="report-panel">
            <h2>Edit User</h2>
            <p class="text-muted">Update user details, role, or password.</p>

            @include('auth.partials.feedback')

            <form method="POST" action="{{ route('dashboard.users.update', $user) }}" class="row g-3">
                @csrf
                @method('PUT')
                @include('dashboard.admin.users.partials.form', ['user' => $user])
                <div class="col-12 d-flex gap-2">
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </section>
    </div>
@endsection

@include('dashboard.admin.users.partials.styles')
