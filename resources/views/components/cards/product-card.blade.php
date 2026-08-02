@props([
    'image',
    'alt' => null,
    'title',
    'price',
    'href' => '#',
])

<article class="product-card">
    <div class="product-card__media">
        <img src="{{ $image }}" alt="{{ $alt ?? $title }}" loading="lazy">
    </div>
    <div class="product-card__body">
        <a class="product-card__title" href="{{ $href }}">{{ $title }}</a>
        <div class="product-card__price">{{ $price }}</div>

        <div class="product-card__controls">
            <button class="product-card__control" type="button" aria-label="В избранное">
                <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-favorite"></use></svg>
                <span>В избранное</span>
            </button>
            <button class="product-card__control" type="button" aria-label="Сравнить">
                <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-compare"></use></svg>
                <span>Сравнить</span>
            </button>
        </div>

        <div class="product-card__footer">
            <a class="button" href="{{ $href }}" aria-label="Добавить в корзину: {{ $title }}">
                <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-bag"></use></svg>
                <span>В корзину</span>
            </a>
        </div>
    </div>
</article>
