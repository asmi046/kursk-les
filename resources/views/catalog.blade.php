@extends('layouts.all')

@php
    $title = 'Разделочные доски — каталог | Курский Лес';
    $description = 'Разделочные доски из массива дуба и ясеня ручной работы. Каталог изделий из натурального дерева.';
@endphp

@section('title', $title)
@section('description', $description)

@section('main')
    {{-- ===================== КАТАЛОГ ===================== --}}
    <section id="catalog" class="catalog section__first" aria-label="Каталог товаров">
        <div class="container">

            <x-breadcrumbs.main :title="'Разделочные'" />

            <h1 class="catalog__title">Разделочные</h1>

            <div class="catalog__inner">
                <aside class="catalog__sidebar" aria-label="Фильтры">
                    <button class="filters-toggle" type="button"
                        data-filters-toggle aria-expanded="false"
                        aria-controls="catalog-filters">
                        <svg class="sprite_icon details__chevron" aria-hidden="true">
                            <use xlink:href="#icon-chevron-down"></use>
                        </svg>
                        <span>Фильтры</span>
                    </button>
                    <div class="filters-collapse" id="catalog-filters" data-filters-collapse>
                        <x-catalog.filters />
                    </div>
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
                                :product="$product"
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
