<section class="restaurant-offer">
    <div class="container">
        <x-breadcrumbs.main title="Эксклюзивное предложение для Кафэ и ресторанов"></x-breadcrumbs.main>

        <div class="restaurant-offer__block">
            @foreach($offers as $index => $offer)
                <div class="restaurant-offer__item {{ $index % 2 === 0 ? 'restaurant-offer__item--image-right' : 'restaurant-offer__item--image-left' }}">
                    <div class="restaurant-offer__text">
                        <div class="restaurant-offer__text-inner">
                            {!! nl2br(e($offer->value)) !!}
                        </div>
                    </div>
                    <div class="restaurant-offer__image">
                        <img src="{{ Storage::url($offer->img) }}" alt="" loading="lazy">
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>