<?php
/**
 * Listentener for invitation creation
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Listeners;

use App\Events\RegistrationInviteCreated;
use App\Notifications\InviteNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class RegistrationInviteSentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationInviteCreated  $event
     * @return void
     */
    public function handle(RegistrationInviteCreated $event)
    {
        // Create temporary signed route which expires after 24 hours after creation
        $signedUrl = URL::temporarySignedRoute('register', now()->addHours(24), ['token' => $event->invite->token]);
        // Send email notification to address with signed route
        Notification::route('mail', $event->invite->email)->notify(new InviteNotification($signedUrl));

        return $signedUrl;
    }
}
