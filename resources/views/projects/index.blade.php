@extends('layouts.all')

@section('main')
    {{-- ===================== ПРОЕКТЫ ===================== --}}
    <section id="projects" class="projects section__first" aria-label="Наши проекты">
        <div class="container">

            <x-breadcrumbs.main :title="'Наши проекты'" />

            <h1 class="section-head section-head--line section-head--top_space">Наши проекты</h1>

            <div class="projects__grid">
                @forelse ($projects as $project)
                    <x-cards.project-card
                        :image="Storage::url($project->img)"
                        :title="$project->title"
                        :href="route('projects.show', ['project' => $project->slug])"
                    />
                @empty
                    <p class="catalog__empty">Проекты не найдены.</p>
                @endforelse
            </div>

            <div class="catalog__pagination">
                <x-pagination.index :tovars="$projects" />
            </div>
        </div>
    </section>
@endsection
