<header class="header-wrapper">
    <div class="header-container">
        <div class="header-branding">
             <div class="header-logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 38px; height: 38px; border-radius: 8px; object-fit: contain;">
            </div>
            <span class="header-name">
                <span class="header-title">Smart Community Problem Reporting System</span>
                <span class="header-subtitle"> - Making Communities Better Through Reporting</span>
            </span>
        </div>

        <button class="header-toggle" id="navToggle" aria-label="Toggle Menu" aria-expanded="false" aria-controls="mainNav">
            <span class="header-toggle-line"></span>
            <span class="header-toggle-line"></span>
            <span class="header-toggle-line"></span>
        </button>

        <nav class="header-nav" id="mainNav">
            @php
                $currentPath = trim(request()->path(), '/');
            @endphp
            <ul>
                <li><a href="/" class="{{ $currentPath === '' ? 'active' : '' }}"><i class="bi bi-house-door"></i> Home</a></li>
                <li><a href="/about" class="{{ $currentPath === 'about' ? 'active' : '' }}"><i class="bi bi-info-circle"></i> About Us</a></li>
                <li><a href="/login" class="{{ $currentPath === 'login' ? 'active' : '' }}"><i class="bi bi-person-circle"></i> Login</a></li>
            </ul>
        </nav>
    </div>
</header>

