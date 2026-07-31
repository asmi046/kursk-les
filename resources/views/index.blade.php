@extends('layouts.all')

@php
    $title = 'Курский Лес — изделия из натурального дерева ручной работы';
    $description = 'Производственная компания «Курский Лес»: наборы для творчества, разделочные доски, торцевые изделия и индивидуальные заказы из массива дерева.';
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
                        <img src="{{ asset('/img/hero/les_text.svg') }}" alt="Курский лес — декоративная надпись старорусским шрифтом" width="460" height="460">
                    </div>

                    <p class="hero__greeting">Приветствуем Вас на фабрике<br>изделий из массива</p>

                    <div class="hero__actions">
                        <a class="button" href="{{ route('home') }}#categories">В каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ПРЕИМУЩЕСТВА ===================== --}}
    <section id="advantages" class="advantages" aria-label="Преимущества">
        <div class="container">
            <div class="advantages__list">
                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-adv-natural"></use></svg>
                    </span>
                    <h2 class="advantages__title">Натурально</h2>
                    <p class="advantages__text">
                        Используем только экологичный массив древесины без вредных примесей.
                    </p>
                </article>

                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-adv-exclusiv"></use></svg>
                    </span>
                    <h2 class="advantages__title">Эксклюзивно</h2>
                    <p class="advantages__text">
                        Каждое изделие уникально и создаётся вручную нашими мастерами.
                    </p>
                </article>

                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-adv-dolgov"></use></svg>
                    </span>
                    <h2 class="advantages__title">Долговечно</h2>
                    <p class="advantages__text">
                        Дерево правильно просушено и обработано, изделия служат годами.
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- ===================== КАТЕГОРИИ ТОВАРА ===================== --}}
    <section id="categories" class="categories" aria-label="Категории товаров">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Категории товара</h2>
                </div>
                <a class="arrow-link" href="{{ route('home') }}#shop">
                    Все категории
                    <span class="arrow-btn" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-arrow-green"></use></svg>
                    </span>
                </a>
            </div>

            <div class="categories__grid">
                <x-cards.category-card
                    :image="asset('/img/categories/cat_nabors.webp')"
                    title="Наборы для творчества"
                    :href="route('home') . '#shop'" />
                <x-cards.category-card
                    :image="asset('/img/categories/cat_razdel.webp')"
                    title="Разделочные доски"
                    :href="route('home') . '#shop'" />
                <x-cards.category-card
                    :image="asset('/img/categories/cat_torcevie.webp')"
                    title="Торцевые изделия"
                    :href="route('home') . '#shop'" />
                <x-cards.category-card
                    :image="asset('/img/categories/cat_podacha.webp')"
                    title="Подставки и подача"
                    :href="route('home') . '#shop'" />
            </div>
        </div>
    </section>

    {{-- ===================== ИНТЕРНЕТ-МАГАЗИН ===================== --}}
    <section id="shop" class="shop" aria-label="Интернет-магазин">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Интернет-магазин</h2>
                </div>
                <a class="arrow-link" href="{{ route('home') }}#categories">
                    Перейти в каталог
                    <span class="arrow-btn" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-arrow-green"></use></svg>
                    </span>
                </a>
            </div>

            <div class="shop__grid">
                <x-cards.product-card
                    :image="asset('/img/shop/magaz_1.webp')"
                    title="Набор «Лесная сказка»"
                    price="1 290 ₽"
                    href="#" />
                <x-cards.product-card
                    :image="asset('/img/shop/magaz_2.webp')"
                    title="Разделочная доска «Классика»"
                    price="990 ₽"
                    href="#" />
                <x-cards.product-card
                    :image="asset('/img/shop/magaz_3.webp')"
                    title="Торцевая доска «Шахматная»"
                    price="2 490 ₽"
                    href="#" />
                <x-cards.product-card
                    :image="asset('/img/shop/magaz_4.webp')"
                    title="Подставка под горячее"
                    price="690 ₽"
                    href="#" />
            </div>
        </div>
    </section>

    {{-- ===================== ИНДИВИДУАЛЬНЫЙ ЗАКАЗ ===================== --}}
    <section id="individual" class="individual" aria-label="Индивидуальный заказ и именные изделия">
        <div class="container">
            <div class="individual__inner">
                <div class="individual__content">
                    <h2 class="individual__title">Индивидуальный заказ и именные изделия</h2>
                    <p class="individual__text">
                        Создадим уникальное изделие по вашему эскизу: именные доски, подарочные
                        наборы и авторские работы. Подберём породу дерева, рисунок и отделку.
                    </p>
                    <div class="individual__actions">
                        <a class="button" href="#individual">Оставить заявку</a>
                        <a class="button button--outline" href="{{ route('home') }}#projects">Наши работы</a>
                    </div>
                    <div class="individual__social">
                        <span class="individual__social-label">Напишите нам:</span>
                        <div class="individual__social-links">
                            <a class="individual__social-link" href="https://max.ru/" target="_blank" rel="noopener noreferrer" aria-label="Написать в MAX">
                                <img src="{{ asset('/img/messengers/max_color.svg') }}" alt="MAX" width="44" height="44">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="individual__slider-wrap">
                    <div class="individual__slider keen-slider" id="individual-slider" aria-label="Примеры индивидуальных изделий">
                        <div class="individual__slide keen-slider__slide">
                            <img src="{{ asset('/img/individual/individual_1.webp') }}" alt="Индивидуальное изделие из дерева — пример 1" loading="lazy">
                        </div>
                        <div class="individual__slide keen-slider__slide">
                            <img src="{{ asset('/img/individual/individual_1.webp') }}" alt="Индивидуальное изделие из дерева — пример 2" loading="lazy">
                        </div>
                    </div>
                    <div class="individual__nav">
                        <button class="slider-nav slider-nav--prev" type="button" aria-label="Предыдущий слайд" data-slider-prev="individual-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-arrow"></use></svg>
                        </button>
                        <button class="slider-nav slider-nav--next" type="button" aria-label="Следующий слайд" data-slider-next="individual-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false"><use xlink:href="#icon-arrow"></use></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== НАШИ ПРОЕКТЫ ===================== --}}
    <section id="projects" class="projects" aria-label="Наши проекты">
        <div class="container">
            <div class="section-head">
                <div>
                    <h2 class="section-title">Наши проекты</h2>
                </div>
                <a class="arrow-link" href="{{ route('home') }}#individual">
                    Все проекты
                    <span class="arrow-btn" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false"><use xlink:href="#icon-arrow-green"></use></svg>
                    </span>
                </a>
            </div>

            <div class="projects__grid">
                <x-cards.project-card
                    :image="asset('/img/projects/proj_1.webp')"
                    title="Подарочный набор для компании"
                    href="#" />
                <x-cards.project-card
                    :image="asset('/img/projects/proj_2.webp')"
                    title="Именная разделочная доска"
                    href="#" />
                <x-cards.project-card
                    :image="asset('/img/projects/proj_3.webp')"
                    title="Авторское торцевое изделие"
                    href="#" />
            </div>
        </div>
    </section>

    {{-- ===================== НЕСКОЛЬКО ПРИЧИН ===================== --}}
    <section id="reasons" class="reasons" aria-label="Несколько причин обратиться к нам">
        <div class="container">
            <div class="reasons__head">
                <h2 class="reasons__title">Несколько причин обратиться к нам</h2>
                <p class="reasons__subtitle">
                    Мы отвечаем за качество каждого изделия и делаем работу, которая остаётся с вами надолго.
                </p>
            </div>

            <div class="reasons__list">
                <article class="reasons__item">
                    <div class="reasons__media">
                        <img src="{{ asset('/img/reasons/pr_1.webp') }}" alt="" loading="lazy">
                    </div>
                    <div class="reasons__body">
                        <h3 class="reasons__item-title">Собственное производство</h3>
                        <p class="reasons__item-text">Полный цикл изготовления — от заготовки до финишной отделки.</p>
                    </div>
                </article>

                <article class="reasons__item">
                    <div class="reasons__media">
                        <img src="{{ asset('/img/reasons/pr_2.webp') }}" alt="" loading="lazy">
                    </div>
                    <div class="reasons__body">
                        <h3 class="reasons__item-title">Опытные мастера</h3>
                        <p class="reasons__item-text">Работаем с деревом много лет и любим своё дело.</p>
                    </div>
                </article>

                <article class="reasons__item">
                    <div class="reasons__media">
                        <img src="{{ asset('/img/reasons/pr_3.webp') }}" alt="" loading="lazy">
                    </div>
                    <div class="reasons__body">
                        <h3 class="reasons__item-title">Контроль качества</h3>
                        <p class="reasons__item-text">Проверяем каждое изделие на прочность и эстетику.</p>
                    </div>
                </article>

                <article class="reasons__item">
                    <div class="reasons__media">
                        <img src="{{ asset('/img/reasons/pr_4.webp') }}" alt="" loading="lazy">
                    </div>
                    <div class="reasons__body">
                        <h3 class="reasons__item-title">Доставка по России</h3>
                        <p class="reasons__item-text">Бережно упакуем и отправим в любой регион.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    {{-- ===================== НАГРАДЫ И СЕРТИФИКАТЫ ===================== --}}
    <section id="certificates" class="certificates" aria-label="Награды и сертификаты">
        <div class="container">
            <div class="certificates__head">
                <h2 class="certificates__title">Награды и сертификаты</h2>
                <p class="certificates__subtitle">
                    Качество нашей продукции подтверждено наградами и сертификатами.
                </p>
            </div>

            <div class="certificates__slider keen-slider" id="certificates-slider" aria-label="Награды и сертификаты">
                <div class="certificates__slide keen-slider__slide">
                    <img src="{{ asset('/img/certificates/cert_1.webp') }}" alt="Сертификат 1" loading="lazy">
                </div>
                <div class="certificates__slide keen-slider__slide">
                    <img src="{{ asset('/img/certificates/cert_2.webp') }}" alt="Сертификат 2" loading="lazy">
                </div>
                <div class="certificates__slide keen-slider__slide">
                    <img src="{{ asset('/img/certificates/cert_1.webp') }}" alt="Сертификат 1" loading="lazy">
                </div>
                <div class="certificates__slide keen-slider__slide">
                    <img src="{{ asset('/img/certificates/cert_2.webp') }}" alt="Сертификат 2" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== О НАС ===================== --}}
    <section id="about" class="about" aria-label="О нас">
        <div class="container">
            <div class="about__inner">
                <div class="about__content">
                    <h2 class="about__title">О нас</h2>
                    <p class="about__text">
                        «Курский Лес» — производственная компания, специализирующаяся на изделиях
                        из натурального дерева. Мы объединяем традиции ручной работы и современный
                        подход к качеству.
                    </p>
                    <p class="about__text">
                        Наша продукция — это наборы для творчества, разделочные и торцевые доски,
                        именные и подарочные изделия. Каждая работа создаётся с вниманием к деталям
                        и любовью к материалу.
                    </p>
                </div>

                <div class="about__media">
                    <div class="about__media-placeholder">
                        <span class="about__play" aria-hidden="true"></span>
                        <span>Видео о компании скоро появится</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
