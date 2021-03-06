<?php
/**
 * Custom Registered User Controller created to handle registration invites
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Controllers;

use App\Models\RegistrationInvite;
use App\Notifications\InviteNotification;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\RegisterViewResponse;

class CustomRegisteredUserController extends RegisteredUserController
{
    /**
     * Show the registration view.
     * overshadowing the original method inside Laravel's default RegisteredUserController
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Laravel\Fortify\Contracts\RegisterViewResponse
     */
    public function create(Request $request): RegisterViewResponse
    {
        /*
         * Return 403 HTTP response code if invitation token is not present nor valid
         */
        if (! $request->hasValidSignature() || $request->get('token') == null || !RegistrationInvite::where('token', $request->get('token'))->exists()) {
            abort(403);
        }
        return app(RegisterViewResponse::class);
    }
}
