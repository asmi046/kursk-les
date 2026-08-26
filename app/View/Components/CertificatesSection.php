<?php

namespace App\View\Components;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Collection;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CertificatesSection extends Component
{
    public Collection $certificates;

    public function __construct()
    {
        $this->certificates = Certificate::orderBy('order')->get();
    }

    public function render(): View|Closure|string
    {
        return view('components.certificates-section');
    }
}
