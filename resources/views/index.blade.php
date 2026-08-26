@extends('layouts.all')

@php
    $title = 'Курский Лес — изделия из натурального дерева ручной работы';
    $description =
        'Производственная компания «Курский Лес»: наборы для творчества, разделочные доски, торцевые изделия и индивидуальные заказы из массива дерева.';
@endphp

@section('title', $title)
@section('description', $description)

@section('main')

    {{-- ===================== HERO ===================== --}}
    <section id="hero" class="hero" aria-label="О компании">
        <div class="container">
            <div class="hero__inner">
                <div class="hero__content">
                    <p class="hero__intro">производственная компания<br>полного цикла</p>

                    <div class="hero__deco-img">
                        <img src="{{ asset('/img/hero/les_text.svg') }}"
                            alt="Курский лес — декоративная надпись старорусским шрифтом" width="460" height="460">
                    </div>

                    <p class="hero__greeting">Приветствуем Вас на фабрике<br>изделий из массива</p>

                    <div class="hero__actions">
                        <a class="button" href="{{ route('home') }}#categories">В каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-advantages-section />

    {{-- ===================== КАТЕГОРИИ ТОВАРА ===================== --}}
    <section id="categories" class="categories" aria-label="Категории товаров">
        <div class="container">
            <div class="categories__grid">
                <x-cards.category-card :image="asset('/img/categories/cat_nabors.webp')" title="Наборы для творчества" :href="route('home') . '#shop'" />
                <x-cards.category-card :image="asset('/img/categories/cat_razdel.webp')" title="Разделочные доски" :href="route('home') . '#shop'" />
                <x-cards.category-card :image="asset('/img/categories/cat_torcevie.webp')" title="Торцевые изделия" :href="route('home') . '#shop'" />
                <x-cards.category-card :image="asset('/img/categories/cat_podacha.webp')" title="Подставки и подача" :href="route('home') . '#shop'" />
            </div>
        </div>
    </section>

    {{-- ===================== ИНТЕРНЕТ-МАГАЗИН ===================== --}}
    <section id="shop" class="shop" aria-label="Интернет-магазин">
        <div class="container">
            <h2 class="section-head">Интернет-магазин</h2>

            <div class="shop__grid">
                <x-cards.product-card :image="asset('/img/shop/magaz_1.webp')" title="Набор «Лесная сказка»" price="1 290 ₽" href="#" />
                <x-cards.product-card :image="asset('/img/shop/magaz_2.webp')" title="Разделочная доска «Классика»" price="990 ₽"
                    href="#" />
                <x-cards.product-card :image="asset('/img/shop/magaz_3.webp')" title="Торцевая доска «Шахматная»" price="2 490 ₽"
                    href="#" />
                <x-cards.product-card :image="asset('/img/shop/magaz_4.webp')" title="Подставка под горячее" price="690 ₽" href="#" />
            </div>
        </div>
    </section>

    <x-individual-section />

    {{-- ===================== НАШИ ПРОЕКТЫ ===================== --}}
    <x-projects-section />

    <x-reasons-section />

    {{-- ===================== О НАС ===================== --}}
    <x-about-section />

    {{-- ===================== НАГРАДЫ И СЕРТИФИКАТЫ ===================== --}}
    <x-certificates-section />



    @endsection
