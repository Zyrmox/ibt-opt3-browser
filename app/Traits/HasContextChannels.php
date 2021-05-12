<?php
/**
 * Trait HasContextChannels adding context channel relation
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

use App\Models\CProp;

trait HasContextChannels
{    
    /**
     * Returns collection of all context channels in relation with parrent model class instance
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function contextChannels()
    {
        return $this->morphMany(CProp::class, 'Type', 'Type', 'refID', 'sId');
    }
}
