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
    <section id="projects" class="projects" aria-label="Наши проекты">
        <div class="container">
            <h2 class="section-head">Наши проекты</h2>

            <div class="projects__grid">
                <x-cards.project-card :image="asset('/img/projects/proj_1.webp')" title="Кабинет руководителя" href="#" />
                <x-cards.project-card :image="asset('/img/projects/proj_2.webp')" title="Окна для проекта мужская гимназия г. Курск"
                    href="#" />
                <x-cards.project-card :image="asset('/img/projects/proj_3.webp')" title="Деревянное зодчество" href="#" />
            </div>
        </div>
    </section>

    <x-reasons-section />

    {{-- ===================== О НАС ===================== --}}
    <section id="about" class="about" aria-label="О нас">
        <div class="container">
            <div class="about__inner">
                <div class="about__content">
                    <h2 class="section-head">О нас</h2>
                    <div class="text_styles">
                        <p>
                            Компания ООО «Курский лес» является одним из крупнейших лесоперерабатывающих
                            предприятий по работе с твердыми породами дерева дуб, бук, ясень, на
                            территории г. Курска и Курской области, работающая более 10 лет.
                            Производственная линия, общей площадью 4200 м², включает в себя цех
                            первичной деревообработки, цех изготовления готовых изделий крупного
                            формата, цех по изготовлению мебели по индивидуальным проектам, цех
                            изготовления изделий из дуба и бука для розницы (торговля на площадках ОЗОН,
                            ВБ, Яндекс маркет), три покрасочные камеры, логистический терминал.
                        </p>
                        <p>
                            ООО «Курский лес» выполняет заказ по государственному контракту -
                            реконструкция Экспозиционного корпуса Курского областного краеведческого
                            мкузея «Здание мужской классической гимназии, 1836 - 1842 гг.»
                        </p>
                        <p>Наша компания активно участвует в помощи бойцам на СВО.</p>
                    </div>
                </div>
                <div class="about__media">
                    <video class="about__video" controls poster="{{ asset('/video/main_present.webp') }}">
                        <source src="{{ asset('/video/davinir_present.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== НАГРАДЫ И СЕРТИФИКАТЫ ===================== --}}
    <x-certificates-section />



    @endsection
