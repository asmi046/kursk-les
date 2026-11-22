@extends('layouts.all')

@section('main')
    {{-- ===================== ТЕКСТОВАЯ СТРАНИЦА ===================== --}}
    <section id="page" class="product section__first" aria-label="{{ $page->title }}">
        <div class="container">

            <x-breadcrumbs.main :title="$page->title" />

            <h1 class="section-head section-head--line section-head--top_space">{{ $page->title }}</h1>

            <div class="text_styles">{!! $page->description !!}</div>
        </div>
    </section>
@endsection
