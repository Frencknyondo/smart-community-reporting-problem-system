<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ThemeManagementController extends Controller
{
    public function index(): View
    {
        return view('dashboard.admin.themes.index', [
            'activeTheme' => Theme::activeOrDefault(),
            'themeHistory' => Theme::query()
                ->where('is_active', false)
                ->latest()
                ->limit(12)
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:80'],
            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        Theme::applyFromPrimary(
            $validated['primary_color'],
            $request->user()->id,
            $validated['name'] ?? null
        );

        return redirect()
            ->route('dashboard.themes.index')
            ->with('success', 'Theme colors applied successfully.');
    }

    public function restore(Request $request, Theme $theme): RedirectResponse
    {
        Theme::query()->where('is_active', true)->update(['is_active' => false]);

        Theme::create([
            'name' => $theme->name.' Restored',
            'primary_color' => $theme->primary_color,
            'primary_strong_color' => $theme->primary_strong_color,
            'primary_dark_color' => $theme->primary_dark_color,
            'primary_soft_color' => $theme->primary_soft_color,
            'primary_border_color' => $theme->primary_border_color,
            'accent_color' => $theme->accent_color,
            'muted_text_color' => $theme->muted_text_color,
            'is_active' => true,
            'created_by' => $request->user()->id,
        ]);

        return redirect()
            ->route('dashboard.themes.index')
            ->with('success', 'Theme history restored and applied successfully.');
    }
}
