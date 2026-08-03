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

    {{-- ===================== ПРЕИМУЩЕСТВА ===================== --}}
    <section id="advantages" class="advantages" aria-label="Преимущества">
        <div class="container">
            <div class="advantages__list">
                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false">
                            <use xlink:href="#icon-adv-natural"></use>
                        </svg>
                    </span>
                    <h2 class="advantages__title">Натуральные<br>материалы</h2>
                    <p class="advantages__text">
                        Для производства наших разделочных и сервировочных досок мы используем только экологически чистые
                        материалы безопасные для человека.
                    </p>
                </article>

                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false">
                            <use xlink:href="#icon-adv-exclusiv"></use>
                        </svg>
                    </span>
                    <h2 class="advantages__title">Эксклюзивный<br>дизайн</h2>
                    <p class="advantages__text">
                        Каждое изделие в нашем интернет магазине это произведение столярного искусства за которым стоит
                        кропотливая работа мастера.
                    </p>
                </article>

                <article class="advantages__item">
                    <span class="advantages__icon" aria-hidden="true">
                        <svg class="sprite_icon" focusable="false">
                            <use xlink:href="#icon-adv-dolgov"></use>
                        </svg>
                    </span>
                    <h2 class="advantages__title">Долговечность<br>изделий</h2>
                    <p class="advantages__text">
                        Благодаря качеству исполнения, качеств сырья и материалов наши изделия будут радовать Вас долгие
                        годы. Сделайте подарок себе и близким!
                    </p>
                </article>
            </div>
        </div>
    </section>

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

    {{-- ===================== ИНДИВИДУАЛЬНЫЙ ЗАКАЗ ===================== --}}
    <section id="individual" class="individual" aria-label="Индивидуальный заказ и именные изделия">
        <div class="container">
            <div class="individual__inner">
                <div class="individual__content">
                    <h2 class="section-head">Индивидуальный заказ и именные изделия</h2>
                    <p class="individual__text">
                        ООО «Курский лес» предлагает своим клиентам уникальную
                        возможность заказать именные подарочные изделия из
                        твердых пород древесины (дуб, бук, ясень) по Вашему
                        индивидуальному проекту. Так же мы принимаем индивидуальные
                        заказы на разработку эксклюзивной мебели и декоративных
                        элементов интерьера.
                    </p>
                    <p class="individual__text">
                        Наша команда способна выполнить пожелания даже
                        самого требовательного заказчика.
                        Свяжитесь с нами для оформления заказа:
                    </p>
                    <div class="individual__social">
                        <div class="individual__social-links">
                            <a class="individual__social-link" href="https://max.ru/" target="_blank"
                                rel="noopener noreferrer" aria-label="Написать в MAX">
                                <img src="{{ asset('/img/messengers/max_color.svg') }}" alt="MAX" width="44"
                                    height="44">
                            </a>
                            <a class="individual__social-link" href="https://max.ru/" target="_blank"
                                rel="noopener noreferrer" aria-label="Написать в MAX">
                                <img src="{{ asset('/img/messengers/max_color.svg') }}" alt="MAX" width="44"
                                    height="44">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="individual__slider-wrap">
                    <div class="individual__slider keen-slider" id="individual-slider"
                        aria-label="Примеры индивидуальных изделий">
                        <div class="individual__slide keen-slider__slide">
                            <img src="{{ asset('/img/individual/individual_1.webp') }}"
                                alt="Индивидуальное изделие из дерева — пример 1" loading="lazy">
                        </div>
                        <div class="individual__slide keen-slider__slide">
                            <img src="{{ asset('/img/individual/individual_1.webp') }}"
                                alt="Индивидуальное изделие из дерева — пример 2" loading="lazy">
                        </div>
                    </div>
                    <div class="individual__nav">
                        <button class="slider-nav slider-nav--next slider-nav--round" type="button"
                            aria-label="Следующий слайд" data-slider-next="individual-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-arrow-individual"></use>
                            </svg>
                        </button>
                        <button class="slider-nav slider-nav--prev slider-nav--round" type="button"
                            aria-label="Предыдущий слайд" data-slider-prev="individual-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-arrow-individual"></use>
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>

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

    {{-- ===================== НЕСКОЛЬКО ПРИЧИН ===================== --}}
    <section id="reasons" class="reasons" aria-label="Несколько причин обратиться к нам">
        <div class="container">
            <div class="reasons__inner">
                <div class="reasons__content">
                    <h2 class="section-head">Несколько причин обратиться к нам</h2>
                    <div class="reasons__list">
                        <div class="reasons__item">
                            <h3 class="reasons__item-title">10 лет опыта</h3>
                            <p class="reasons__item-text">За 10 лет безупречной работы мы реализовали сотни индивидуальных
                                проектов, отточили мастерство и выстроили надёжные цепочки поставок.</p>
                        </div>
                        <div class="reasons__item">
                            <h3 class="reasons__item-title">Профессиональное оборудование</h3>
                            <p class="reasons__item-text">Наше производство оснащено современными высокоточными станками,
                                ЧПУ покрасочными камерами и логистическим терминалом, что обеспечивает непрерывный
                                техпроцесс и высокое качество сервиса для наших клиентов.</p>
                        </div>
                        <div class="reasons__item">
                            <h3 class="reasons__item-title">Собственная сырьевая база</h3>
                            <p class="reasons__item-text">Мы работаем с проверенными поставщиками и располагаем стабильными
                                запасами высококачественной древесины: дуба, бука и ясеня. Это позволяет нам строго
                                контролировать качество изделий на всех этапах.</p>
                        </div>
                        <div class="reasons__item">
                            <h3 class="reasons__item-title">Внимание к деталям</h3>
                            <p class="reasons__item-text">Совершенство состоит из мелочей! От подбора текстуры древесины до
                                финишной шлифовки и тонировки — у нас каждый этап проходит тщательный контроль! Наши мастера
                                учитывают малейшие пожелания заказчика.</p>
                        </div>
                    </div>
                </div>
                <div class="reasons__media">
                    <div class="reasons__grid">
                        <img src="{{ asset('/img/reasons/pr_1.webp') }}" alt="" loading="lazy"
                            class="reasons__img">
                        <img src="{{ asset('/img/reasons/pr_2.webp') }}" alt="" loading="lazy"
                            class="reasons__img">
                        <img src="{{ asset('/img/reasons/pr_3.webp') }}" alt="" loading="lazy"
                            class="reasons__img">
                        <img src="{{ asset('/img/reasons/pr_4.webp') }}" alt="" loading="lazy"
                            class="reasons__img">
                    </div>
                </div>
            </div>
        </div>
    </section>

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
    <section id="certificates" class="certificates" aria-label="Награды и сертификаты">
        <div class="container">
            <h2 class="section-head">Награды и сертификаты</h2>

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



@endsection
