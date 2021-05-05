<?php

namespace App\Traits;

trait GloballySearchable
{
    abstract public static function primaryKey();

    protected function initializeGloballySearchable()
    {
        $this->append('url');
    }

    protected function getUrlAttribute()
    {
        return route( 'insights.' . strtolower(class_basename(self::class)), ['id' => $this->sId]);
    }

    public static function search($attr, $search) {
        $primary = self::primaryKey();
        return empty($search) ? static::query()
            : static::query()->where(isset($attr) ? $attr : $primary, 'like', '%'. $search .'%');
    }
}
