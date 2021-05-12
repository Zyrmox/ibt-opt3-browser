<?php
/**
 * Livewire Component Controller - Invitations Form
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Organisms;

use App\Models\RegistrationInvite;
use Livewire\Component;

class InvitationsForm extends Component
{
    public $invitations;

    /**
     * Gets called on component mount
     *
     * @return void
     */
    public function mount()
    {
        $this->invitations = RegistrationInvite::all();
    }

    public function render()
    {
        return view('livewire.organisms.invitations-form');
    }
}
