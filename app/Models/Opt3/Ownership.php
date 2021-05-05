<?php

namespace App\Models\Opt3;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Ownership extends Pivot
{
    protected $connection = 'tenant';
    protected $table = 'ownership';

    protected $fillable = [
        'type', 'fobjsId', 'tobjsId'
    ];
}
