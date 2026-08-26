<?php

namespace App\View\Components;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProjectsSection extends Component
{
    public Collection $projects;

    public function __construct()
    {
        $this->projects = Project::all();
    }

    public function render(): View|Closure|string
    {
        return view('components.projects-section');
    }
}
