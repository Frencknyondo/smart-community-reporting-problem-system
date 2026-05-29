@php
    $preferredTheme = auth()->user()->theme_preference ?? request()->cookie('scprs_theme', 'light');
    $preferredTheme = in_array($preferredTheme, ['light', 'dark'], true) ? $preferredTheme : 'light';
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="{{ $preferredTheme }}" data-theme-scope="{{ auth()->check() ? 'profile' : 'browser' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') | Smart Community Problem Reporting System</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <script>
        (() => {
            try {
                const storedTheme = localStorage.getItem('scprs-theme');
                const themeScope = document.documentElement.dataset.themeScope;
                if (themeScope !== 'profile' && (storedTheme === 'light' || storedTheme === 'dark')) {
                    document.documentElement.dataset.theme = storedTheme;
                }
            } catch (error) {}
        })();
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/rootcolor.css') }}" rel="stylesheet">
    @include('theme')
    <link href="{{ asset('css/frankAuth.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frankTheme.css') }}" rel="stylesheet">
</head>

<body class="auth-layout-body" data-disable-navigation-overlay="1" data-inline-spinner-links="1">
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/frankTheme.js') }}"></script>
    <script src="{{ asset('js/frankButtonSpinner.js') }}"></script>
    @yield('scripts')
</body>

</html>

