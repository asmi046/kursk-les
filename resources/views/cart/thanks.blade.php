@extends('layouts.all')

@section('main')
    <section id="cart-thanks" class="cart-thanks section__first">
        <div class="container">
            <h1 class="section-head section-head--line section-head--top_space">Заказ оформлен</h1>
            <p>Спасибо! Ваш заказ №{{ $orderId }} принят. Мы свяжемся с вами для подтверждения.</p>
            <a class="button" href="{{ route('home') }}">На главную</a>
        </div>
    </section>
@endsection
