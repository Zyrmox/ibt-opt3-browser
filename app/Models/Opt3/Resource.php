<?php

namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\GloballySearchable;
use App\Traits\HasContextChannels;
use App\Traits\HasDBFileConnection;
use App\Traits\Namable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Namable,
        Filterable,
        GloballySearchable,
        HasContextChannels;
        
    const TYPE_ALL = -1;
    const TYPE_MACHINE = 0;
    const TYPE_PERSONNEL = 2;
    const TYPE_TOOL = 3;

    static $types = [
        self::TYPE_MACHINE => 'Stroj',
        self::TYPE_PERSONNEL => 'Personál',
        self::TYPE_TOOL => 'Nástroj',
        self::TYPE_ALL => 'Všechny',
    ];

    protected $connection = 'tenant';
    protected $table = 'resources';
    protected $primaryKey = 'sId';
    protected $keyType = 'string';

    protected $fillable = [
        'sId', 'type', 'parallelType', 'maxICap',
        'parallelCap', 'maxDCap', 'matCapacity',
    ];

    protected $color = 'pink-600';
    
    /**
     * Replaces model attributes by formatted value
     *
     * @return array
     */
    protected function formatFilteredFields() {
        return [
            'type' => [
                'format' => '{formatted}',
                'value' => function() {
                    return self::$types[$this->type];
                }
            ],
        ];
    }
    
    /**
     * Returns model's primary key name
     *
     * @return string
     */
    public static function primaryKey() {
        return (new static())->getKeyName();
    }
    
    /**
     * Set substitution group name to be used in short_id table
     *
     * @return string
     */
    public function setSubstitutionGroup()
    {
        return str_replace(' ', '_', mb_strtolower($this->type(), 'UTF-8'));
    }

    public function setSubstitutionPosition()
    {
        return self::where('type', $this->type)->get()->search(function ($model, $key) {
            return $model->sId == $this->sId;
        }) + 1;
    }

    public function type() {
        return self::$types[$this->type];
    }

    public function isType($type) {
        return $this->type == $type;
    }

    public function resCalendar() {
        return $this->hasMany(ResCalendar::class, 'ressId', 'sId');
    }

    public function color() {
        return 'text-' . $this->color;
    }
}
