<section id="categories" class="categories" aria-label="Категории товаров">
    <div class="container">
        <div class="categories__grid">
            @foreach($categories as $category)
                <x-cards.category-card
                    :image="Storage::url($category->img)"
                    :title="$category->title"
                    :href="route('category.show', ['slug' => $category->slug])"
                />
            @endforeach
        </div>
    </div>
</section>