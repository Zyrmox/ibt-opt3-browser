<?php
/**
 * Trait GloballySearchable used for looking up specific objects
 * of manufacturing task by its UUID or its substring
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

trait GloballySearchable
{
    abstract public static function primaryKey();

    protected function initializeGloballySearchable()
    {
        // Appends attribute url to parent class instance
        $this->append('url');
    }
    
    /**
     * Returns composed URL of found object based on it's class name
     *
     * @return void
     */
    protected function getUrlAttribute()
    {
        return route( 'insights.' . strtolower(class_basename(self::class)), ['id' => $this->sId]);
    }
    
    /**
     * Search UUID among all database tables
     *
     * @param  mixed $attr
     * @param  mixed $search searched substring of object UUID
     * @return void
     */
    public static function search($attr, $search) {
        $primary = self::primaryKey();
        return empty($search) ? static::query()
            : static::query()->where(isset($attr) ? $attr : $primary, 'like', '%'. $search .'%');
    }
}
