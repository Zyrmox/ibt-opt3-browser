<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class ExpandableCard extends Component
{
    public $expanded;
    public $bgColor;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($expanded = false, $bgColor = 'bg-white', $disabled = false)
    {
        $this->expanded = $expanded;
        $this->bgColor = $bgColor;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.molecules.expandable-card');
    }
}
