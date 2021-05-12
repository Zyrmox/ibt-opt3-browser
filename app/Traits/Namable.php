<?php
/**
 * Trait Namable responsible for creating UUID substitutions for model
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Traits;

trait Namable
{
    protected function initializeNamable()
    {
        // Apend the short_id attribute to model instance
        $this->append('short_id');
    }

    /**
     * Set substitution group name to be used in short_id table
     *
     * @return string
     */
    protected function setSubstitutionGroup() {
        return strtolower(class_basename(self::class));
    }
    
    /**
     * Accessor - Retrieves UUID substitution from database, create one if not exists
     *
     * @return string
     */
    protected function getShortIdAttribute()
    {
        return shortId()->trans(currentTenantDBFile()->url, $this->sId, $this->setSubstitutionGroup(), self::class, isset($pos) ? $pos : null);
    }

    /**
     * Creates UUID substitution
     *
     * @return string
     */
    public function createSubstitution() {
        if (method_exists($this, 'setSubstitutionPosition')) {
            $pos = $this->setSubstitutionPosition();
        }
        return shortId()->trans(currentTenantDBFile()->url, $this->sId, $this->setSubstitutionGroup(), self::class, isset($pos) ? $pos : null);
    }
    
    /**
     * Returns model based on short_id
     *
     * @param  string $short_id
     * @return void
     */
    public static function findByShortId($short_id) {
        $parts = explode("_", $short_id);
        $position = intval(end($parts)) - 1;
        return self::all()->toArray()[$position];
    }
}
