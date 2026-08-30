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
    <x-categories-section />

    {{-- ===================== ИНТЕРНЕТ-МАГАЗИН ===================== --}}
    <x-shop-section />

    <x-individual-section />

    {{-- ===================== НАШИ ПРОЕКТЫ ===================== --}}
    <x-projects-section />

    <x-reasons-section />

    {{-- ===================== О НАС ===================== --}}
    <x-about-section />

    {{-- ===================== НАГРАДЫ И СЕРТИФИКАТЫ ===================== --}}
    <x-certificates-section />



    @endsection
