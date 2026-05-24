@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="report-panel">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h2>User Management</h2>
                    <p class="text-muted mb-0">View users and their current system roles.</p>
                </div>
                <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-1"></i> Add User
                </a>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge text-bg-primary">{{ ucfirst($user->role) }}</span></td>
                                <td>{{ $user->created_at?->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('dashboard.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" @disabled(auth()->id() === $user->id)>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $users->links() }}
        </section>
    </div>
@endsection

@push('styles')
    <style>
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
    </style>
@endpush
