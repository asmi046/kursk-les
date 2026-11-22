@extends('layouts.all')

@section('main')
    {{-- ===================== ПРОЕКТ ===================== --}}
    <section id="project" class="product section__first" aria-label="{{ $project->title }}">
        <div class="container">

            <x-breadcrumbs.main :title="$project->title" parent-title="Наши проекты" :parent-href="route('projects.index')" />

            <h1 class="section-head section-head--line section-head--top_space">{{ $project->title }}</h1>

            <div class="product__inner">

                <div class="project__slider-col">
                    <div class="product__slider-wrap">
                        <div class="product__slider keen-slider" id="product-slider" data-lightbox data-lightbox-group="project" aria-label="{{ $project->title }}">
                            @forelse ($project->gallery ?? [] as $item)
                                <div class="product__slide keen-slider__slide">
                                    <img src="{{ Storage::url($item['img']) }}" alt="{{ $item['alt'] ?? $project->title }}"
                                        loading="lazy">
                                </div>
                            @empty
                                <div class="product__slide keen-slider__slide">
                                    <img src="{{ Storage::url($project->img) }}" alt="{{ $project->title }}" loading="lazy">
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="individual__nav">
                        <button class="slider-nav slider-nav--next slider-nav--round" type="button"
                            aria-label="Следующий слайд" data-slider-next="product-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-arrow-individual"></use>
                            </svg>
                        </button>
                        <button class="slider-nav slider-nav--prev slider-nav--round" type="button"
                            aria-label="Предыдущий слайд" data-slider-prev="product-slider">
                            <svg class="sprite_icon" aria-hidden="true" focusable="false">
                                <use xlink:href="#icon-arrow-individual"></use>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="product__info">
                    <div class="product__description" data-readmore>
                        <div class="product__description-inner text_styles" data-readmore-inner>{!! $project->description !!}</div>
                        <button class="product__readmore" type="button"
                            data-readmore-toggle
                            data-text-open="Читать полностью"
                            data-text-close="Свернуть">Читать полностью</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== ИНДИВИДУАЛЬНЫЙ ЗАКАЗ ===================== --}}
    <x-individual-section />
@endsection
