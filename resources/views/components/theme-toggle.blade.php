@props([
    'label' => 'Theme',
    'variant' => 'default',
])

<button
    type="button"
    class="theme-toggle theme-toggle--{{ $variant }}"
    data-theme-toggle
    @auth data-theme-endpoint="{{ route('theme.preference.update') }}" @endauth
    aria-label="Switch theme"
    aria-pressed="false"
>
    <span class="theme-toggle__track" aria-hidden="true">
        <span class="theme-toggle__option theme-toggle__option--light">
            <i class="bi bi-sun-fill"></i>
        </span>
        <span class="theme-toggle__option theme-toggle__option--dark">
            <i class="bi bi-moon-stars-fill"></i>
        </span>
        <span class="theme-toggle__thumb"></span>
    </span>
    <span class="theme-toggle__label">{{ $label }}</span>
</button>
