<?php

namespace App\View\Components\Atoms;

use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class SecondarySidebarLink extends Component
{
    public $route;
    public $bgColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route = null)
    {
        $this->route = isset($route) ? route($route) : '#';
        $this->bgColor = Route::current()->getName() == (isset($route) ? $route : '') ? 'bg-white' : 'bg-theme-300';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.atoms.secondary-sidebar-link');
    }
}
