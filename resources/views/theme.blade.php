@php
    $activeTheme = \App\Models\Theme::activeOrDefault();
@endphp

<style id="scprs-dynamic-theme">
    :root {
        --color-primary-500: {{ $activeTheme->primary_color }};
        --color-primary-600: {{ $activeTheme->primary_strong_color }};
        --color-primary-700: {{ $activeTheme->primary_dark_color }};
        --color-primary-200: {{ $activeTheme->primary_border_color }};
        --color-primary-300: {{ $activeTheme->primary_border_color }};
        --color-primary-400: {{ $activeTheme->accent_color }};
        --color-primary-50: {{ $activeTheme->primary_soft_color }};
        --color-slate-500: {{ $activeTheme->muted_text_color }};
        --color-primary-500-rgb: {{ $activeTheme->primaryRgb() }};
        --color-primary-600-rgb: {{ $activeTheme->primaryStrongRgb() }};
        --theme-primary: {{ $activeTheme->primary_color }};
        --theme-primary-strong: {{ $activeTheme->primary_strong_color }};
        --theme-muted-text: {{ $activeTheme->muted_text_color }};
        --bs-primary: {{ $activeTheme->primary_color }};
        --bs-primary-rgb: {{ $activeTheme->primaryRgb() }};
        --bs-link-color: {{ $activeTheme->primary_strong_color }};
        --bs-link-hover-color: {{ $activeTheme->primary_dark_color }};
    }

    .btn-primary {
        --bs-btn-bg: {{ $activeTheme->primary_strong_color }};
        --bs-btn-border-color: {{ $activeTheme->primary_strong_color }};
        --bs-btn-hover-bg: {{ $activeTheme->primary_dark_color }};
        --bs-btn-hover-border-color: {{ $activeTheme->primary_dark_color }};
        --bs-btn-active-bg: {{ $activeTheme->primary_dark_color }};
        --bs-btn-active-border-color: {{ $activeTheme->primary_dark_color }};
        --bs-btn-disabled-bg: {{ $activeTheme->primary_strong_color }};
        --bs-btn-disabled-border-color: {{ $activeTheme->primary_strong_color }};
    }

    .btn-outline-primary {
        --bs-btn-color: {{ $activeTheme->primary_strong_color }};
        --bs-btn-border-color: {{ $activeTheme->primary_strong_color }};
        --bs-btn-hover-bg: {{ $activeTheme->primary_strong_color }};
        --bs-btn-hover-border-color: {{ $activeTheme->primary_strong_color }};
        --bs-btn-active-bg: {{ $activeTheme->primary_dark_color }};
        --bs-btn-active-border-color: {{ $activeTheme->primary_dark_color }};
    }
</style>
