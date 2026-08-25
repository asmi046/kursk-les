<section id="advantages" class="advantages" aria-label="Преимущества">
    <div class="container">
        <div class="advantages__list">
            @foreach($items as $item)
                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false">
                            <use xlink:href="{{ $item->icon }}"></use>
                        </svg>
                    </span>
                    <h2 class="advantages__title">{!! $item->title !!}</h2>
                    <p class="advantages__text">{{ $item->value }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>