@extends('layouts.all')

@php
    $title = '';
    $description = '';
@endphp

@section('title', $title)
@section('description', $description)

@section('main')

    <section id="temporary-placeholder" class="placeholder">
        <div class="container">
            <div class="placeholder__content">
                <div class="placeholder__top">
                    <img class="placeholder__logo" src="{{ asset('/img/logo_v.svg') }}" alt="Курский Лес">

                    <div class="placeholder__text">
                        <h1>Производственная компани Курский Лес</h1>

                        <p>Наш сайт в данный момент находится в процессе разработки, с нашей продукцией Вы сожете
                            ознакомится в официальных магазинах на маркетплейсах:</p>
                    </div>
                </div>

                <div class="placeholder__bottom" aria-label="Магазины на маркетплейсах">
                    <a class="placeholder__marketplace" href="https://www.ozon.ru/brand/devinir-100931078/?__rr=1"
                        target="_blank" rel="noopener noreferrer" aria-label="Магазин Курский Лес на Ozon">
                        <img class="placeholder__marketplace-logo" src="{{ asset('/img/marketplaces/ozon_logo.svg') }}"
                            alt="Ozon">
                        <img class="placeholder__marketplace-qr" src="{{ asset('/img/marketplaces/ozon.png') }}"
                            alt="QR-код Ozon магазина">
                    </a>

                    <a class="placeholder__marketplace"
                        href="https://market.yandex.ru/business--ooo-kurskii-les/173188186?utm_medium=sharing&generalContext=t%3DshopInShop%3Bi%3D1%3Bbi%3D173188186%3B&rs=eJwz4v_EyMPBKLDwEKsEg8a5I6wAJTkEmQ%2C%2C&searchContext=sins_ctx"
                        target="_blank" rel="noopener noreferrer" aria-label="Магазин Курский Лес на Яндекс Маркете">
                        <img class="placeholder__marketplace-logo" src="{{ asset('/img/marketplaces/YM_logo.svg') }}"
                            alt="Яндекс Маркет">
                        <img class="placeholder__marketplace-qr" src="{{ asset('/img/marketplaces/ym.png') }}"
                            alt="QR-код магазина Яндекс Маркета">
                    </a>

                    <a class="placeholder__marketplace" href="https://www.wildberries.ru/seller/1209707" target="_blank"
                        rel="noopener noreferrer" aria-label="Магазин Курский Лес на Wildberries">
                        <img class="placeholder__marketplace-logo" src="{{ asset('/img/marketplaces/wb_logo.svg') }}"
                            alt="Wildberries">
                        <img class="placeholder__marketplace-qr" src="{{ asset('/img/marketplaces/wb.png') }}"
                            alt="QR-код магазина Wildberries">
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
