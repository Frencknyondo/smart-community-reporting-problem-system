@php
    $preferredTheme = auth()->user()->theme_preference ?? request()->cookie('scprs_theme', 'light');
    $preferredTheme = in_array($preferredTheme, ['light', 'dark'], true) ? $preferredTheme : 'light';
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="{{ $preferredTheme }}" data-theme-scope="{{ auth()->check() ? 'profile' : 'browser' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart Community Problem Reporting System')</title>
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

    @vite(['resources/css/vendor.css', 'resources/js/app.js'])
    <link href="{{ asset('css/rootcolor.css') }}" rel="stylesheet">
    @include('theme')


    <!-- Custom CSS -->
    <link href="{{ asset('css/frankPublicHeader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frankPublicFooter.css') }}" rel="stylesheet">

    <link href="{{ asset('css/frankAuth.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frankTheme.css') }}" rel="stylesheet">
    @stack('critical-head')
    @stack('styles')
    <style>
        :root {
            --font-heading: "Segoe UI", "Trebuchet MS", Verdana, sans-serif;
            --font-body: "Segoe UI", "Trebuchet MS", Verdana, sans-serif;
        }

        body {
            font-family: var(--font-body);
        }

        h1,h2,h3,h4,h5, h6,
        .section-title,
        .hero-title,
        .header-name {
            font-family: var(--font-heading);
        }

        .btn {
            font-family: var(--font-heading);
        }

        p, li,a, span, input, select,textarea, label,
        small {
            font-family: var(--font-body);
        }
    </style>

</head>

<body class="d-flex flex-column min-vh-100" data-disable-navigation-overlay="1" data-inline-spinner-links="1" data-inline-spinner-theme="blue">
    @stack('page_loader')
    @include('components.header')

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Custom JS -->
    <script src="{{ asset('js/frankPublicHeader.js') }}"></script>
    <script src="{{ asset('js/frankTheme.js') }}"></script>
    <script src="{{ asset('js/frankButtonSpinner.js') }}"></script>
    @yield('scripts')
    @stack('scripts')

</body>

</html>

