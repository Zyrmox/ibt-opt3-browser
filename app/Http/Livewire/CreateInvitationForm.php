<?php

namespace App\Http\Livewire;

use App\Events\RegistrationInviteCreated;
use App\Models\RegistrationInvite;
use App\Notifications\InviteNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class CreateInvitationForm extends Component
{
    public $email;
    public $emailSent = false;

    protected $rules = [
        'email' => 'email|required|unique:registration_invites,email',
    ];

    /**
     * Create and send registration invitation
     *
     * @return void
     */
    public function send()
    {
        $this->validate();
        
        if (RegistrationInvite::where('email', $this->email)->exists()) {
            $this->addError('email', 'Již existuje pozvánka se shodnou e-mailovou adresou!');
        }

        do {
            $token = Str::random(40);
        } while (RegistrationInvite::where('token', $token)->first());

        $invite = RegistrationInvite::create([
            'token' => $token,
            'email' => $this->email
        ]);

        event(new RegistrationInviteCreated($invite));
        
        $this->emailSent = true;
        session()->flash('success', 'Pozvánka k registraci byla úspěšně odeslána!');
    }

    public function render()
    {
        return view('livewire.create-invitation-form');
    }
}
