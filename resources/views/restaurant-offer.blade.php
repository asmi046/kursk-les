@extends('layouts.all')

@section('main')
    <section class="restaurant-hero section__first" aria-label="Эксклюзивное предложение для Кафэ и ресторанов">
        <div class="container">
            <h1 class="restaurant-hero__title">
                Эксклюзивное предложение <br>
                <span>для Кафэ и ресторанов</span>
            </h1>
        </div>
    </section>

    <x-restaurant-offer-section />
@endsection
