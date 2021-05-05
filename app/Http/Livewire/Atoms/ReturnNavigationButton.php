<?php

namespace App\Http\Livewire\Atoms;

use Livewire\Component;

class ReturnNavigationButton extends Component
{
    public $url;

    public function mount() {
        $this->url = url()->previous();
    }

    public function render()
    {
        return view('livewire.atoms.return-navigation-button');
    }
}
