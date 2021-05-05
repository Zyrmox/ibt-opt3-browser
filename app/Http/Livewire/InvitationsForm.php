<?php

namespace App\Http\Livewire;

use App\Models\RegistrationInvite;
use Livewire\Component;

class InvitationsForm extends Component
{
    public $invitations;

    public function mount()
    {
        $this->invitations = RegistrationInvite::all();
    }

    public function render()
    {
        return view('livewire.invitations-form');
    }
}
