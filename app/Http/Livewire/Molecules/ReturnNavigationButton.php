<?php
/**
 * Livewire Component Controller - Navigation Return Button
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */

namespace App\Http\Livewire\Molecules;

use Livewire\Component;

class ReturnNavigationButton extends Component
{
    public $url;

    /**
     * Gets called on component mount
     *
     * @return void
     */
    public function mount() {
        $this->url = url()->previous();
    }

    public function render()
    {
        return view('livewire.molecules.return-navigation-button');
    }
}
