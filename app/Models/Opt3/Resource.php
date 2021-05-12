<?php
/**
 * Resource Model - representing  table "Resources" and its entities
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
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
        
    /* All possible types (forms) of Resource in manufacturing task */
    const TYPE_ALL = -1;
    const TYPE_MACHINE = 0;
    const TYPE_PERSONNEL = 2;
    const TYPE_TOOL = 3;

    /**
     * Types to names (string) mapping
     *
     * @var array
     */
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
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    /**
     * Set substitution position aka index to be used in short_id table
     * overshadowing method from trait Namable
     *
     * @return string
     */
    public function setSubstitutionPosition()
    {
        return self::where('type', $this->type)->get()->search(function ($model, $key) {
            return $model->sId == $this->sId;
        }) + 1;
    }

    /**
     * Returns resource type
     *
     * @return string
     */
    public function type() {
        return self::$types[$this->type];
    }
    
    /**
     * Checks whether resource is of type
     *
     * @param  mixed $type
     * @return bool
     */
    public function isType($type) {
        return $this->type == $type;
    }
    
    /**
     * Returns all corresponding material events linked with material instance
     *
     * @return void
     */
    public function resCalendar() {
        return $this->hasMany(ResCalendar::class, 'ressId', 'sId');
    }

    public function color() {
        return 'text-' . $this->color;
    }
}
