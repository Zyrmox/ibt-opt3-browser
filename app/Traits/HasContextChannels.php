<?php

namespace App\Traits;

use App\Models\CProp;

trait HasContextChannels
{
    public function contextChannels()
    {
        return $this->morphMany(CProp::class, 'Type', 'Type', 'refID', 'sId');
    }
}
