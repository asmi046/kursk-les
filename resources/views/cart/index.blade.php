@php
    $payDir = 'img/pay_icons';
    $payIcons = collect([
        ['file' => 'mir-color-logo.svg', 'alt' => 'Мир'],
        ['file' => 'sber-color-logo.svg', 'alt' => 'СберPay'],
        ['file' => 'sbp-color-logo-black.svg', 'alt' => 'СБП'],
        ['file' => 't-pat-color-logo.svg', 'alt' => 'Т-Пэй'],
        ['file' => 'alpha-color.svg', 'alt' => 'Alpha Pay'],
    ])->map(fn ($icon) => ['src' => asset("{$payDir}/{$icon['file']}"), 'alt' => $icon['alt']])->values();
@endphp

@extends('layouts.all')

@section('main')
    <div id="cart_app" data-pay-icons='@json($payIcons)'
        data-policy-url="{{ route('page.show', 'personal-data-policy') }}"
        data-consent-url="{{ route('page.show', 'personal-data-consent') }}"></div>
@endsection
