<section id="shop" class="shop" aria-label="Интернет-магазин">
    <div class="container">
        <h2 class="section-head">Интернет-магазин</h2>

        <div class="shop__grid">
            @foreach($products as $product)
                <x-cards.product-card
                    :image="Storage::url($product->img)"
                    :title="$product->title"
                    :price="number_format($product->price, 0, '', ' ') . ' ₽'"
                    :href="route('product.show', ['slug' => $product->slug])"
                />
            @endforeach
        </div>

        <div class="shop__more">
            <a class="button" href="{{ route('catalog') }}">Все товары</a>
        </div>
    </div>
</section>