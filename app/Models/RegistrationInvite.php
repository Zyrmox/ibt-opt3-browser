<?php
/**
 * Registration Invite Model
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationInvite extends Model
{
    use HasFactory;

    protected $fillable=[
        'email',
        'token',
    ];
    
    /**
     * Returns e-mail address linked with token, that was send to specified address.
     * This value is used to fill the e-mail input in registration form.
     * 
     * @param  string $token
     * @return void
     */
    public static function email($token) {
        if ($token == null) {
            abort(403);
        }
        return ($result = self::where('token', $token))->exists() ? $result->first()->email : '';
    }
}
