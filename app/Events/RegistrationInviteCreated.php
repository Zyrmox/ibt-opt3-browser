<?php
/**
 * Listentener for invitation creation
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Events;

use App\Models\RegistrationInvite;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegistrationInviteCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * Register invitation instance
     *
     * @var \App\Models\RegistrationInvite
     */
    public $invite;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RegistrationInvite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
