@extends('layouts.all')

@section('main')
    {{-- ===================== ИЗБРАННОЕ ===================== --}}
    <section id="favorites" class="favorites section__first" aria-label="Избранное">
        <div class="container">

            <x-breadcrumbs.main :title="'Избранное'" />

            <h1 class="section-head section-head--line section-head--top_space">Избранное</h1>

            <div id="favorites_app"></div>
        </div>
    </section>
@endsection
