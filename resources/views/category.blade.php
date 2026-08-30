@extends('layouts.all')

@section('main')
    <section id="catalog" class="catalog section__first" aria-label="{{ $category->title }}">
        <div class="container">

            <x-breadcrumbs.main :title="$category->title" />

            <h1 class="catalog__title">{{ $category->title }}</h1>

            @if($category->description)
                <p class="catalog__desc">{{ $category->description }}</p>
            @endif

            <div class="catalog__inner">
                <aside class="catalog__sidebar" aria-label="Фильтры">
                    <x-catalog.filters />
                </aside>

                <div class="catalog__main">
                    <x-catalog.toolbar />

                    <div class="catalog__grid">
                        @forelse ($tovars as $product)
                            @php
                                $productHref = \Illuminate\Support\Facades\Route::has('product.show')
                                    ? route('product.show', ['slug' => $product->slug])
                                    : '#';
                            @endphp
                            <x-cards.product-card
                                :image="Storage::url($product->img)"
                                :title="$product->title"
                                :price="number_format($product->price, 0, '', ' ') . ' ₽'"
                                :href="$productHref"
                            />
                        @empty
                            <p class="catalog__empty">Товары не найдены.</p>
                        @endforelse
                    </div>

                    <div class="catalog__pagination">
                        <x-pagination.index :tovars="$tovars" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
