@php
    $isAdministrationMenuOpen = request()->is('dashboard/profile*') || request()->is('dashboard/settings*');
    $isMonitoringMenuOpen = request()->is('dashboard/notifications*');
    $role = auth()->user()->role ?? 'citizen';
@endphp

<aside id="sidebar" class="frank-sidebar">
    <div class="p-3 frank-sidebar-inner">
        <div class="frank-sidebar-brand mb-4">
            <div class="frank-sidebar-logo" aria-hidden="true">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </div>
            <div class="frank-sidebar-brand-text">
                <div class="frank-sidebar-brand-title">SCPRS</div>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}"
                    class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
            </li>

            @if ($role === 'citizen')
                <li class="nav-item">
                    <a href="{{ route('dashboard.citizen.reports.create') }}"
                        class="nav-link {{ request()->routeIs('dashboard.citizen.reports.create') ? 'active' : '' }}">
                        <i class="bi bi-geo-alt-fill"></i> Report an Issue
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.citizen.reports.track') }}"
                        class="nav-link {{ request()->routeIs('dashboard.citizen.reports.track') ? 'active' : '' }}">
                        <i class="bi bi-list-task"></i> Track My Reports
                    </a>
                </li>
            @endif

            @if (in_array($role, ['admin', 'council'], true))
                <li class="nav-item">
                    <a href="{{ route('dashboard.reports.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.reports.index') ? 'active' : '' }}">
                        <i class="bi bi-clipboard2-pulse-fill"></i> Reported Issues
                    </a>
                </li>
            @endif

            @if ($role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('dashboard.users.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.users.index') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i> User Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.themes.index') }}"
                        class="nav-link {{ request()->routeIs('dashboard.themes.index') ? 'active' : '' }}">
                        <i class="bi bi-palette-fill"></i> Theme Management
                    </a>
                </li>
            @endif

            <li class="nav-item">
                <a href="{{ route('dashboard.notifications.index') }}"
                    class="nav-link {{ request()->is('dashboard/notifications*') ? 'active' : '' }}">
                    <i class="bi bi-bell-fill"></i> Notifications
                </a>
            </li>
        </ul>

            <div class="frank-sidebar-footer">
                <div class="frank-sidebar-footer__copy">&copy; 2025 Smart Community Problem Reporting System</div>
            </div>
    </div>
</aside>

<style>
    .frank-sidebar .nav-link {
        border-radius: 12px;
        margin-bottom: 4px;
        padding: 10px 16px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .frank-sidebar .nav-link:hover {
        background: rgba(var(--color-primary-500-rgb), 0.08);
        color: var(--color-primary-500);
    }

    .frank-sidebar .nav-link.active {
        color: var(--color-white);
        box-shadow: 0 8px 16px rgba(var(--color-primary-500-rgb), 0.2);
    }
</style>

