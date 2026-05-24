@props([
    'title',
    'subtitle' => null,
])

<div class="frank-shared-page-header__text">
    <h1 class="frank-shared-page-header__title">{{ $title }}</h1>
    @if ($subtitle)
        <p class="frank-shared-page-header__subtitle">{{ $subtitle }}</p>
    @endif
</div>

