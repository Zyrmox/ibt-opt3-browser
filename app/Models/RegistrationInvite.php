<?php

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

    public static function email(string $token) {
        if ($token == null) {
            abort(403);
        }
        return ($result = self::where('token', $token))->exists() ? $result->first()->email : '';
    }
}
