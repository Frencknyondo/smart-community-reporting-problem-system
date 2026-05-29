@extends('layouts.frankDashboardLayout')

@section('content')
    <div class="container-fluid px-3 px-lg-4 py-4">
        <section class="theme-management-panel">
            <div class="theme-management-header">
                <div>
                    <h2>Theme Management</h2>
                    <p class="text-muted mb-0">Choose one primary color and the system will generate matching light theme colors.</p>
                </div>
                <span class="theme-active-badge">Active: {{ $activeTheme->name }}</span>
            </div>

            <div class="theme-management-grid">
                <div class="theme-color-card">
                    <span class="theme-color-swatch" style="--swatch-color: {{ $activeTheme->primary_color }};"></span>
                    <div>
                        <strong>Primary</strong>
                        <span>{{ $activeTheme->primary_color }}</span>
                    </div>
                </div>
                <div class="theme-color-card">
                    <span class="theme-color-swatch" style="--swatch-color: {{ $activeTheme->primary_strong_color }};"></span>
                    <div>
                        <strong>Primary Strong</strong>
                        <span>{{ $activeTheme->primary_strong_color }}</span>
                    </div>
                </div>
                <div class="theme-color-card">
                    <span class="theme-color-swatch" style="--swatch-color: {{ $activeTheme->primary_soft_color }};"></span>
                    <div>
                        <strong>Soft Surface</strong>
                        <span>{{ $activeTheme->primary_soft_color }}</span>
                    </div>
                </div>
                <div class="theme-color-card">
                    <span class="theme-color-swatch" style="--swatch-color: {{ $activeTheme->muted_text_color }};"></span>
                    <div>
                        <strong>Muted Text</strong>
                        <span>{{ $activeTheme->muted_text_color }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="theme-picker-panel">
            <form method="POST" action="{{ route('dashboard.themes.store') }}" class="theme-picker-form" data-theme-picker-form>
                @csrf
                <div class="theme-picker-main">
                    <div class="theme-picker-box">
                        <div class="theme-picker-box__surface" data-picker-surface>
                            <input
                                type="color"
                                name="primary_color"
                                value="{{ old('primary_color', $activeTheme->primary_color) }}"
                                aria-label="Choose primary theme color"
                                data-primary-picker
                            >
                        </div>
                        <div class="theme-picker-box__meta">
                            <span>Pick Primary Color</span>
                            <strong data-preview-primary>{{ old('primary_color', $activeTheme->primary_color) }}</strong>
                        </div>
                    </div>

                    <div class="theme-picker-controls">
                        <div class="theme-input-group">
                            <label for="themeName">Theme name</label>
                            <input id="themeName" type="text" name="name" class="form-control" placeholder="Custom theme name">
                        </div>

                        <div class="theme-preview-card" data-theme-preview-card>
                            <div class="theme-preview-card__bar"></div>
                            <div class="theme-preview-card__body">
                                <span>Live Preview</span>
                                <strong>Admin Dashboard Card</strong>
                                <p>Buttons, sidebar, cards, and headings will follow this primary color.</p>
                                <button type="button">Sample Button</button>
                            </div>
                        </div>

                        <div class="theme-generated-grid">
                            <div>
                                <span>Primary Strong</span>
                                <strong data-preview-strong>{{ $activeTheme->primary_strong_color }}</strong>
                            </div>
                            <div>
                                <span>Muted Text</span>
                                <strong data-preview-muted>{{ $activeTheme->muted_text_color }}</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary theme-apply-btn">
                            <i class="bi bi-check2-circle me-1"></i> Apply Theme
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="theme-history-panel">
            <div class="theme-history-header">
                <div>
                    <h3>Theme History</h3>
                    <p class="text-muted mb-0">Previous colors that were applied before the current active theme.</p>
                </div>
            </div>

            @if ($themeHistory->isEmpty())
                <div class="theme-empty-history">
                    <i class="bi bi-clock-history"></i>
                    <strong>No theme history yet</strong>
                    <span>Previous colors will appear here after you apply a new theme.</span>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle theme-history-table">
                        <thead>
                            <tr>
                                <th>Theme</th>
                                <th>Primary</th>
                                <th>Primary Strong</th>
                                <th>Muted Text</th>
                                <th>Changed</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($themeHistory as $theme)
                                <tr>
                                    <td>{{ $theme->name }}</td>
                                    <td>
                                        <span class="theme-history-color">
                                            <i style="--swatch-color: {{ $theme->primary_color }}"></i>
                                            {{ $theme->primary_color }}
                                        </span>
                                    </td>
                                    <td>{{ $theme->primary_strong_color }}</td>
                                    <td>{{ $theme->muted_text_color }}</td>
                                    <td>{{ $theme->created_at?->format('M d, Y H:i') }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('dashboard.themes.restore', $theme) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Restore
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .theme-management-panel,
        .theme-picker-panel,
        .theme-history-panel {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .theme-management-header,
        .theme-history-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .theme-management-panel h2,
        .theme-history-panel h3 {
            margin: 0 0 0.35rem;
            font-size: 1.35rem;
            font-weight: 800;
        }

        .theme-active-badge {
            display: inline-flex;
            align-items: center;
            min-height: 34px;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            background: var(--color-primary-50);
            color: var(--color-primary-600);
            font-size: 0.78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .theme-management-grid,
        .theme-generated-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
        }

        .theme-color-card,
        .theme-generated-grid > div {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            min-height: 84px;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f8fafc;
        }

        .theme-color-swatch {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--swatch-color);
            border: 1px solid rgba(15, 23, 42, 0.1);
            flex-shrink: 0;
        }

        .theme-color-card strong,
        .theme-color-card span,
        .theme-generated-grid span,
        .theme-generated-grid strong {
            display: block;
        }

        .theme-color-card strong,
        .theme-generated-grid strong {
            color: #111827;
            font-size: 0.94rem;
        }

        .theme-color-card span,
        .theme-generated-grid span {
            color: var(--color-slate-500);
            font-size: 0.82rem;
        }

        .theme-picker-main {
            display: grid;
            grid-template-columns: minmax(260px, 360px) minmax(0, 1fr);
            gap: 1.2rem;
            align-items: stretch;
        }

        .theme-picker-box {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            background: #111827;
        }

        .theme-picker-box__surface {
            min-height: 260px;
            display: grid;
            place-items: center;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.78), rgba(0, 0, 0, 0.15)),
                linear-gradient(90deg, #ffffff, var(--picker-color, #3B82F6));
        }

        .theme-picker-box__surface input[type="color"] {
            width: 92px;
            height: 92px;
            padding: 0;
            border: 4px solid #ffffff;
            border-radius: 18px;
            background: transparent;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.26);
            cursor: pointer;
        }

        .theme-picker-box__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 0.9rem 1rem;
            color: #ffffff;
        }

        .theme-picker-box__meta span {
            color: rgba(255, 255, 255, 0.76);
            font-size: 0.82rem;
        }

        .theme-picker-controls {
            display: grid;
            gap: 1rem;
        }

        .theme-input-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: #111827;
            font-weight: 800;
            font-size: 0.85rem;
        }

        .theme-preview-card {
            border: 1px solid rgba(var(--preview-primary-rgb, 59, 130, 246), 0.18);
            border-radius: 14px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.06);
        }

        .theme-preview-card__bar {
            height: 10px;
            background: linear-gradient(90deg, var(--preview-primary, #3B82F6), var(--preview-strong, #2563EB));
        }

        .theme-preview-card__body {
            padding: 1rem;
        }

        .theme-preview-card__body span {
            color: var(--preview-muted, #64748B);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .theme-preview-card__body strong {
            display: block;
            margin-top: 0.2rem;
            color: #111827;
            font-size: 1.08rem;
        }

        .theme-preview-card__body p {
            max-width: 560px;
            margin: 0.45rem 0 0.9rem;
            color: var(--preview-muted, #64748B);
            font-size: 0.9rem;
        }

        .theme-preview-card__body button,
        .theme-apply-btn {
            border: 0;
            border-radius: 10px;
            padding: 0.65rem 1rem;
            background: var(--preview-strong, var(--color-primary-600));
            color: #ffffff;
            font-weight: 800;
        }

        .theme-generated-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .theme-empty-history {
            min-height: 160px;
            display: grid;
            place-items: center;
            text-align: center;
            gap: 0.35rem;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            color: var(--color-slate-500);
            padding: 1rem;
        }

        .theme-empty-history i {
            color: var(--color-primary-600);
            font-size: 1.7rem;
        }

        .theme-empty-history strong {
            color: #111827;
        }

        .theme-history-color {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            font-weight: 700;
        }

        .theme-history-color i {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            background: var(--swatch-color);
            border: 1px solid rgba(15, 23, 42, 0.12);
        }

        @media (max-width: 1199.98px) {
            .theme-management-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .theme-management-header,
            .theme-history-header {
                flex-direction: column;
            }

            .theme-management-grid,
            .theme-generated-grid,
            .theme-picker-main {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('[data-theme-picker-form]');
            if (!form) return;

            const picker = form.querySelector('[data-primary-picker]');
            const surface = form.querySelector('[data-picker-surface]');
            const previewCard = form.querySelector('[data-theme-preview-card]');
            const primaryOutput = form.querySelector('[data-preview-primary]');
            const strongOutput = form.querySelector('[data-preview-strong]');
            const mutedOutput = form.querySelector('[data-preview-muted]');

            const hexToRgb = (hex) => {
                const value = hex.replace('#', '');
                return [
                    parseInt(value.substring(0, 2), 16),
                    parseInt(value.substring(2, 4), 16),
                    parseInt(value.substring(4, 6), 16),
                ];
            };

            const rgbToHex = (rgb) => `#${rgb.map((part) => Math.round(part).toString(16).padStart(2, '0')).join('')}`.toUpperCase();

            const mix = (hex, target, percent) => {
                const rgb = hexToRgb(hex);
                const targetRgb = hexToRgb(target);
                const ratio = percent / 100;
                return rgbToHex(rgb.map((part, index) => part + (targetRgb[index] - part) * ratio));
            };

            const syncPreview = () => {
                const primary = picker.value.toUpperCase();
                const strong = mix(primary, '#000000', 16);
                const muted = mix(primary, '#475569', 26);
                const primaryRgb = hexToRgb(primary).join(', ');

                surface.style.setProperty('--picker-color', primary);
                previewCard.style.setProperty('--preview-primary', primary);
                previewCard.style.setProperty('--preview-strong', strong);
                previewCard.style.setProperty('--preview-muted', muted);
                previewCard.style.setProperty('--preview-primary-rgb', primaryRgb);
                primaryOutput.textContent = primary;
                strongOutput.textContent = strong;
                mutedOutput.textContent = muted;
            };

            picker.addEventListener('input', syncPreview);
            syncPreview();
        });
    </script>
@endpush
