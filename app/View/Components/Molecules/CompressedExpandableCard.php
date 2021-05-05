<?php

namespace App\View\Components\Molecules;

use Illuminate\View\Component;

class CompressedExpandableCard extends Component
{
    public $expanded;
    public $disablePaddingX;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($expanded = false, $disablePaddingX = false)
    {
        $this->expanded = $expanded;
        $this->disablePaddingX = $disablePaddingX;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.molecules.compressed-expandable-card');
    }
}
