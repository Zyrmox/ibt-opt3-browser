<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortId extends Model
{
    public $timestamps = false;

    protected $fillable = [
        "file_id", "model_id", "group", "type", "short_id"
    ];
}
