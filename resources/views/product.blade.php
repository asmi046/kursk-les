@extends('layouts.all')

@php
    $title = $product->title . ' — Курский Лес';
    $description = $product->description;
@endphp

@section('title', $title)
@section('description', $description)

@section('main')
    {{-- ===================== ТОВАР ===================== --}}
    <section id="product" class="product section__first" aria-label="{{ $product->title }}">
        <div class="container">

            <x-breadcrumbs.main :title="$product->title" />

            <h1 class="section-head section-head--line section-head--top_space">{{ $product->title }}</h1>

            <div class="product__inner">

                <div class="product__slider-wrap">
                    <div class="product__slider keen-slider" id="product-slider" aria-label="{{ $product->title }}">
                        <div class="product__slide keen-slider__slide">
                            <img src="{{ Storage::url($product->img) }}" alt="{{ $product->title }}" loading="lazy">
                        </div>
                        @foreach ($product->galery ?? [] as $item)
                            <div class="product__slide keen-slider__slide">
                                <img src="{{ Storage::url($item['img']) }}" alt="{{ $item['title'] ?? $product->title }}"
                                    loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="product__info">
                    <ul class="product__quick">
                        <li class="product__quick-item">
                            <span class="product__quick-label product__quick-label--model">Модель</span>
                            <span class="product__quick-value">{{ $product->model }}</span>
                        </li>
                        <li class="product__quick-item">
                            <span class="product__quick-label product__quick-label--exist">Наличие</span>
                            <span class="product__quick-value">На складе</span>
                        </li>
                        <li class="product__quick-item">
                            <span class="product__quick-label product__quick-label--weight">Вес</span>
                            <span class="product__quick-value">{{ $product->weight }}</span>
                        </li>
                    </ul>

                    <div class="product__description">
                        <div class="product__description-inner text_styles">{!! $product->description !!}</div>
                        <button class="product__readmore" type="button" data-readmore-toggle>Читать полностью</button>
                    </div>

                    <ul class="product__specs">
                        <li class="product__specs-row">
                            <span class="product__specs-label">Тип</span>
                            <span class="product__specs-value">{{ $product->type }}</span>
                        </li>
                        <li class="product__specs-row">
                            <span class="product__specs-label">Длина, см</span>
                            <span class="product__specs-value">{{ preg_replace('/[^0-9.]/', '', $product->length) }}</span>
                        </li>
                        <li class="product__specs-row">
                            <span class="product__specs-label">Ширина, см</span>
                            <span class="product__specs-value">{{ preg_replace('/[^0-9.]/', '', $product->wigth) }}</span>
                        </li>
                        <li class="product__specs-row">
                            <span class="product__specs-label">Толщина, см</span>
                            <span class="product__specs-value">{{ preg_replace('/[^0-9.]/', '', $product->height) }}</span>
                        </li>
                        <li class="product__specs-row">
                            <span class="product__specs-label">Количество в упаковке, шт</span>
                            <span class="product__specs-value">1</span>
                        </li>
                    </ul>
                </div>

                <aside class="product__buy">
                    <div class="product__buy-top">
                        <div class="product__qty">
                            <button class="product__qty-btn" type="button" data-qty="-">−</button>
                            <input class="product__qty-input" type="number" name="qty" value="1" min="1">
                            <button class="product__qty-btn" type="button" data-qty="+">+</button>
                        </div>
                        <button class="product__add button" type="button">
                            <svg class="sprite_icon" aria-hidden="true">
                                <use xlink:href="#icon-bag"></use>
                            </svg>
                            <span>В корзину</span>
                        </button>
                    </div>

                    <div class="product__actions">
                        <button class="product__action" type="button">
                            <svg class="sprite_icon" aria-hidden="true">
                                <use xlink:href="#icon-favorite"></use>
                            </svg>
                            <span>В избранное</span>
                        </button>
                        <button class="product__action" type="button">
                            <svg class="sprite_icon" aria-hidden="true">
                                <use xlink:href="#icon-compare"></use>
                            </svg>
                            <span>В сравнение</span>
                        </button>
                    </div>

                    <h3 class="product__color-title">Цвет</h3>
                    <div class="product__color-list">
                        @foreach (['Классический', 'Коричневый', 'Шоколадный', 'Графит'] as $color)
                            <label class="product__color-option">
                                <input type="checkbox" class="product__color-checkbox" value="{{ $color }}">
                                <span class="product__color-mark"></span>
                                <span>{{ $color }}</span>
                            </label>
                        @endforeach
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- ===================== ПОХОЖИЕ ТОВАРЫ ===================== --}}
    <section id="related" class="related" aria-label="Похожие товары">
        <div class="container">
            <h2 class="section-head">Похожие товары</h2>
            <div class="related__grid">
                @foreach ($related as $item)
                    <x-cards.product-card :image="Storage::url($item->img)" :title="$item->title" :price="number_format($item->price, 0, '', ' ') . ' ₽'" :href="route('product.show', ['slug' => $item->slug])" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===================== ИНДИВИДУАЛЬНЫЙ ЗАКАЗ ===================== --}}
    <x-individual-section />
@endsection
