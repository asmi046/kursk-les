@props([
    'image',
    'alt' => null,
    'title',
    'price',
    'href' => '#',
    'product' => null,
])

<article class="product-card">
    <a class="product-card__link" href="{{ $href }}" aria-label="{{ $title }}">{{ $title }}</a>
    <div class="product-card__media">
        <img src="{{ $image }}" alt="{{ $alt ?? $title }}" loading="lazy">
    </div>
    <div class="product-card__body">
        <div class="product-card__title">{{ $title }}</div>
        <div class="product-card__price">{{ $price }}</div>

        <div class="product-card__controls">
            @if ($product)
                <div data-list-toggle data-type="favorite" data-variant="card"
                    data-product-id="{{ $product->id }}"></div>
                <div data-list-toggle data-type="compare" data-variant="card"
                    data-product-id="{{ $product->id }}"></div>
            @else
                <button class="product-card__control" type="button" aria-label="В избранное">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-favorite"></use></svg>
                    <span>В избранное</span>
                </button>
                <button class="product-card__control" type="button" aria-label="Сравнить">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-compare"></use></svg>
                    <span>Сравнить</span>
                </button>
            @endif
        </div>

        <div class="product-card__footer">
            @if ($product)
                @php
                    $cartProduct = [
                        'id' => $product->id,
                        'url' => route('product.show', $product->slug),
                        'img' => $product->img ? asset('storage/' . $product->img) : null,
                        'title' => $product->title,
                        'price' => (float) $product->price,
                        'characteristic' => trim($product->type . ', ' . $product->material, ' ,'),
                        'colors' => $product->colors ?? [],
                    ];
                @endphp
                <div class="product-card__to-cart" data-cart-add='@json($cartProduct)'>
                </div>
            @else
                <a class="button" href="{{ $href }}" aria-label="Добавить в корзину: {{ $title }}">
                    <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-bag"></use></svg>
                    <span>В корзину</span>
                </a>
            @endif
        </div>
    </div>
</article>
