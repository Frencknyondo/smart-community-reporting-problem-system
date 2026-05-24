<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        return match ($request->user()->role) {
            'admin' => redirect()->route('dashboard.admin.index'),
            'council' => redirect()->route('dashboard.council.index'),
            default => redirect()->route('dashboard.citizen.index'),
        };
    }

    public function admin(): View
    {
        $statusCounts = Report::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalReports = (int) $statusCounts->sum();
        $resolvedReports = (int) ($statusCounts['resolved'] ?? 0);
        $activeReports = Report::whereIn('status', ['open', 'under_review', 'in_progress'])->count();
        $unreadNotifications = AuditTrail::where('actor_id', auth()->id())
            ->where('actor_type', User::class)
            ->where('status', 'unread')
            ->count();

        $statusBreakdown = collect([
            'open' => ['label' => 'Open', 'tone' => 'danger'],
            'under_review' => ['label' => 'Under Review', 'tone' => 'warning'],
            'in_progress' => ['label' => 'In Progress', 'tone' => 'info'],
            'resolved' => ['label' => 'Resolved', 'tone' => 'success'],
        ])->map(function (array $status, string $key) use ($statusCounts, $totalReports) {
            $count = (int) ($statusCounts[$key] ?? 0);

            return [
                ...$status,
                'key' => $key,
                'count' => $count,
                'percent' => $totalReports > 0 ? round(($count / $totalReports) * 100) : 0,
            ];
        })->values();

        return view('dashboard.admin.index', [
            'stats' => [
                [
                    'label' => 'Reported Issues',
                    'value' => $totalReports,
                    'detail' => 'All submitted issues',
                    'icon' => 'bi-clipboard2-pulse-fill',
                    'tone' => 'primary',
                    'route' => route('dashboard.reports.index'),
                ],
                [
                    'label' => 'Active Cases',
                    'value' => $activeReports,
                    'detail' => 'Open, review, or progress',
                    'icon' => 'bi-hourglass-split',
                    'tone' => 'warning',
                    'route' => route('dashboard.reports.index'),
                ],
                [
                    'label' => 'Resolved',
                    'value' => $resolvedReports,
                    'detail' => 'Completed reports',
                    'icon' => 'bi-check-circle-fill',
                    'tone' => 'success',
                    'route' => route('dashboard.reports.index'),
                ],
                [
                    'label' => 'System Users',
                    'value' => User::count(),
                    'detail' => 'Registered accounts',
                    'icon' => 'bi-people-fill',
                    'tone' => 'info',
                    'route' => route('dashboard.users.index'),
                ],
            ],
            'shortcuts' => [
                [
                    'label' => 'Dashboard',
                    'detail' => 'Admin overview',
                    'icon' => 'bi-grid-fill',
                    'route' => route('dashboard.admin.index'),
                ],
                [
                    'label' => 'Reported Issues',
                    'detail' => 'Review and update cases',
                    'icon' => 'bi-clipboard2-pulse-fill',
                    'route' => route('dashboard.reports.index'),
                ],
                [
                    'label' => 'User Management',
                    'detail' => 'Manage system users',
                    'icon' => 'bi-people-fill',
                    'route' => route('dashboard.users.index'),
                ],
                [
                    'label' => 'Notifications',
                    'detail' => $unreadNotifications.' unread alerts',
                    'icon' => 'bi-bell-fill',
                    'route' => route('dashboard.notifications.index'),
                ],
            ],
            'statusBreakdown' => $statusBreakdown,
            'recentReports' => Report::with(['category', 'reporter'])->latest()->limit(5)->get(),
            'resolutionPercent' => $totalReports > 0 ? round(($resolvedReports / $totalReports) * 100) : 0,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }

    public function council(): View
    {
        return view('dashboard.council.index');
    }

    public function citizen(Request $request): View
    {
        $user = $request->user();
        $myReports = Report::with('category')
            ->where('user_id', $user->id);

        $recentReports = (clone $myReports)
            ->latest()
            ->limit(5)
            ->get();

        $mapReports = (clone $myReports)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest()
            ->limit(20)
            ->get(['id', 'title', 'location', 'latitude', 'longitude', 'priority', 'status']);

        $stats = [
            [
                'label' => 'My Reports',
                'value' => (clone $myReports)->count(),
                'detail' => 'Total Reports',
                'icon' => 'bi-file-earmark-text',
                'tone' => 'primary',
            ],
            [
                'label' => 'Pending Issues',
                'value' => (clone $myReports)->whereIn('status', ['open', 'under_review', 'in_progress'])->count(),
                'detail' => 'Open or In Progress',
                'icon' => 'bi-hourglass-split',
                'tone' => 'warning',
            ],
            [
                'label' => 'Resolved Reports',
                'value' => (clone $myReports)->where('status', 'resolved')->count(),
                'detail' => 'Resolved',
                'icon' => 'bi-check-circle',
                'tone' => 'success',
            ],
            [
                'label' => 'Community Supports',
                'value' => 0,
                'detail' => 'Supports Received',
                'icon' => 'bi-hand-thumbs-up',
                'tone' => 'info',
            ],
        ];

        $nearbyAlerts = Report::with('category')
            ->where('user_id', '!=', $user->id)
            ->whereIn('priority', ['high', 'emergency'])
            ->latest()
            ->limit(3)
            ->get();

        return view('dashboard.citizen.index', [
            'stats' => $stats,
            'recentReports' => $recentReports,
            'mapReports' => $mapReports,
            'nearbyAlerts' => $nearbyAlerts,
            'mapConfig' => config('map'),
            'resolvedCount' => (clone $myReports)->where('status', 'resolved')->count(),
        ]);
    }
}
