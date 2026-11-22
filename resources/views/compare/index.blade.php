@extends('layouts.all')

@section('main')
    {{-- ===================== СРАВНЕНИЕ ===================== --}}
    <section id="compare" class="compare section__first" aria-label="Сравнение товаров">
        <div class="container">

            <x-breadcrumbs.main :title="'Сравнение товаров'" />

            <h1 class="section-head section-head--line section-head--top_space">Сравнение товаров</h1>

            <div id="compare_app"></div>
        </div>
    </section>
@endsection
