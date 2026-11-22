@php
    $payDir = 'img/pay_icons';
    $payIcons = [
        ['file' => 'mir-color-logo.svg', 'alt' => 'Мир'],
        ['file' => 'sber-color-logo.svg', 'alt' => 'СберPay'],
        ['file' => 'sbp-color-logo.svg', 'alt' => 'СБП'],
        ['file' => 't-pat-color-logo.svg', 'alt' => 'Т-Пэй'],
        ['file' => 'alpha-color.svg', 'alt' => 'Alpha Pay'],
    ];
@endphp

<div class="pay-icons" aria-label="Способы оплаты">
    <p class="pay-icons__title">В наш магазин можно оплатить следующими способами:</p>
    @foreach ($payIcons as $icon)
        <img class="pay-icons__item" src="{{ asset("{$payDir}/{$icon['file']}") }}" alt="{{ $icon['alt'] }}"
            width="56" height="32" loading="lazy">
    @endforeach
</div>
