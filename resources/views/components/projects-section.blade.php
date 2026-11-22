<section id="projects" class="projects" aria-label="Наши проекты">
    <div class="container">
        <h2 class="section-head">Наши проекты</h2>

        <div class="projects__grid">
            @foreach($projects as $project)
                <x-cards.project-card :image="Storage::url($project->img)" :title="$project->title" :href="route('projects.show', ['project' => $project->slug])" />
            @endforeach
        </div>

        <div class="projects__all">
            <a class="button button--outline" href="{{ route('projects.index') }}">Все проекты</a>
        </div>
    </div>
</section>