<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class CompressedExpandableTr extends Component
{
    public $expanded;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($expanded = false)
    {
        $this->expanded = $expanded;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.molecules.compressed-expandable-tr');
    }
}
