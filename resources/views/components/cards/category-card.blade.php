@props([
    'image',
    'alt' => null,
    'title',
    'href' => '#',
])

<a class="category-card" href="{{ $href }}">
    <div class="category-card__media">
        <img src="{{ $image }}" alt="{{ $alt ?? $title }}" loading="lazy">
    </div>
    <div class="category-card__body">
        <span class="category-card__title">{{ $title }}</span>
        <span class="category-card__arrow" aria-hidden="true">
            <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-arrow-green"></use></svg>
        </span>
    </div>
</a>
