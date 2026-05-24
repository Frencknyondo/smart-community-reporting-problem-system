<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Models\Report;
use App\Models\ReportCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function create(): View
    {
        return view('dashboard.citizen.reports.create', [
            'categories' => ReportCategory::orderBy('name')->get(),
            'mapConfig' => config('map'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'category_id' => ['required', 'exists:report_categories,id'],
            'location' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'priority' => ['required', 'in:low,medium,high,emergency'],
            'image' => ['nullable', 'image', 'max:4096'],
            'video' => ['nullable', 'file', 'mimetypes:video/mp4,video/quicktime,video/x-msvideo', 'max:20480'],
            'is_anonymous' => ['nullable', 'boolean'],
        ]);

        try {
            $report = new Report($validated);
            $report->user_id = $request->user()->id;
            $report->status = 'open';
            $report->is_anonymous = $request->boolean('is_anonymous');

            if ($request->hasFile('image')) {
                $report->image_path = $this->storePublicReportFile($request->file('image'), 'images');
            }

            if ($request->hasFile('video')) {
                $report->video_path = $this->storePublicReportFile($request->file('video'), 'videos');
            }

            $report->save();

            $this->notifyUser(
                $request->user(),
                'Report submitted successfully',
                'Your report is sent to council for review.',
                $report
            );

            User::whereIn('role', ['admin', 'council'])->get()->each(function (User $user) use ($report) {
                $this->notifyUser(
                    $user,
                    'New reported issue',
                    "A new {$report->priority} priority issue was submitted: {$report->title}.",
                    $report,
                    'report.new'
                );
            });
        } catch (\Throwable $exception) {
            AuditTrail::create([
                'actor_type' => User::class,
                'actor_id' => $request->user()->id,
                'actor_name' => $request->user()->full_name,
                'action' => 'notification',
                'description' => 'Your report was not sent. Please check the form and try again.',
                'status' => 'unread',
                'metadata' => ['title' => 'Report not sent'],
            ]);

            return back()
                ->withInput()
                ->with('error', 'Report was not sent. Please try again.');
        }

        return redirect()
            ->route('dashboard.citizen.reports.create')
            ->with('success', 'Issue reported successfully. Your report is sent to council.');
    }

    public function index(Request $request): View
    {
        $query = Report::with(['category', 'reporter'])->latest();

        if ($request->user()->role === 'citizen') {
            $query->where('user_id', $request->user()->id);
        }

        return view('dashboard.reports.index', [
            'reports' => $query->paginate(12),
            'mapConfig' => config('map'),
        ]);
    }

    public function trackReports(Request $request): View
    {
        $reports = Report::with(['category'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(12);

        $statusCounts = [
            'total' => Report::where('user_id', $request->user()->id)->count(),
            'open' => Report::where('user_id', $request->user()->id)->where('status', 'open')->count(),
            'under_review' => Report::where('user_id', $request->user()->id)->where('status', 'under_review')->count(),
            'in_progress' => Report::where('user_id', $request->user()->id)->where('status', 'in_progress')->count(),
            'resolved' => Report::where('user_id', $request->user()->id)->where('status', 'resolved')->count(),
        ];

        return view('dashboard.citizen.reports.track', [
            'reports' => $reports,
            'statusCounts' => $statusCounts,
            'mapConfig' => config('map'),
        ]);
    }

    public function updateStatus(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:open,under_review,in_progress,resolved'],
        ]);

        $oldStatus = $report->status;
        $report->update(['status' => $validated['status']]);

        if ($oldStatus !== $report->status && $report->reporter) {
            $this->notifyUser(
                $report->reporter,
                'Report status updated',
                "Your report '{$report->title}' status changed to ".str_replace('_', ' ', $report->status).'.',
                $report,
                'report.status_updated'
            );
        }

        return back()->with('success', 'Report status updated successfully.');
    }

    private function notifyUser(User $user, string $title, string $message, Report $report, string $action = 'report.submitted'): void
    {
        AuditTrail::create([
            'actor_type' => User::class,
            'actor_id' => $user->id,
            'actor_name' => $user->full_name,
            'action' => $action,
            'description' => $message,
            'subject_type' => Report::class,
            'subject_id' => $report->id,
            'subject_name' => $report->title,
            'route_name' => 'dashboard.reports.index',
            'status' => 'unread',
            'metadata' => [
                'title' => $title,
                'report_id' => $report->id,
                'priority' => $report->priority,
                'report_status' => $report->status,
            ],
        ]);
    }

    private function storePublicReportFile($file, string $type): string
    {
        $directory = public_path("img/reports/{$type}");

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = now()->format('YmdHis').'-'.Str::random(10).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return asset("img/reports/{$type}/{$filename}");
    }
}
