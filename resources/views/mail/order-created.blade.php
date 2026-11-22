<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333;">
    <h2>Новый заказ №{{ $order->id }}</h2>

    <p>
        <strong>ФИО:</strong> {{ $order->name }}<br>
        <strong>Телефон:</strong> {{ $order->phone }}<br>
        @if ($order->email)
            <strong>E-mail:</strong> {{ $order->email }}<br>
        @endif
        <strong>Сумма товаров:</strong> {{ number_format((float) $order->items_summ, 0, '', ' ') }} ₽<br>
        <strong>Доставка:</strong> {{ number_format((float) $order->delivery_price, 0, '', ' ') }} ₽<br>
        <strong>Итого:</strong> {{ number_format((float) $order->total_summ, 0, '', ' ') }} ₽
    </p>

    @if ($order->comment)
        <p><strong>Комментарий:</strong><br>{{ $order->comment }}</p>
    @endif

    <h3>Доставка</h3>
    <p>
        <strong>Способ:</strong>
        {{ $order->delivery->method === 'pickup_point' ? 'Пункт выдачи СДЭК' : 'Курьер СДЭК' }}<br>
        @if ($order->delivery->city)
            <strong>Город:</strong> {{ $order->delivery->city }}<br>
        @endif
        @if ($order->delivery->pickup_point_address)
            <strong>Пункт выдачи:</strong> {{ $order->delivery->pickup_point_address }} ({{ $order->delivery->pickup_point_id }})<br>
        @endif
        @if ($order->delivery->street)
            <strong>Адрес:</strong> ул. {{ $order->delivery->street }}, д. {{ $order->delivery->house }}@if ($order->delivery->apartment)
                , кв. {{ $order->delivery->apartment }}
            @endif<br>
        @endif
        @if ($order->delivery->tariff)
            <strong>Тариф:</strong> {{ $order->delivery->tariff }}
        @endif
    </p>

    <h3>Состав заказа</h3>
    <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th align="left">Товар</th>
                <th align="left">Цвет</th>
                <th align="right">Цена</th>
                <th align="right">Кол-во</th>
                <th align="right">Сумма</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->color ?? '—' }}</td>
                    <td align="right">{{ number_format((float) $item->price, 0, '', ' ') }} ₽</td>
                    <td align="right">{{ $item->quantity }}</td>
                    <td align="right">{{ number_format((float) $item->price * $item->quantity, 0, '', ' ') }} ₽</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
