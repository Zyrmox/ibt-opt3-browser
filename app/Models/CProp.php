<?php
/**
 * CProp Model - Represent Context channel
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models;

use App\Models\Opt3\Job;
use App\Models\Opt3\Resource;
use App\Traits\Filterable;
use App\Traits\HasDBFileConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CProp extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Filterable;
        
    const TYPE_OPERATION = -1;
    const TYPE_RESOURCE_MACHINE = 0;
    const TYPE_RESOURCE_TOOL = 2;

    static $types = [
        self::TYPE_OPERATION => 'Operace',
        self::TYPE_RESOURCE_MACHINE => 'Stroj',
        self::TYPE_RESOURCE_TOOL => 'Nástroj'
    ];

    static $typeToModel = [
        self::TYPE_OPERATION => Job::class,
        self::TYPE_RESOURCE_MACHINE => Resource::class,
        self::TYPE_RESOURCE_TOOL => Resource::class
    ];

    protected $connection = 'tenant';
    protected $table = 'cprop';
    protected $keyType = 'string';

    protected $fillable = [
        'Type', 'refID', 'cChannel', 'resourceRefID',
        'Name', 'reqValue', 'initValue', 'opcode', 'schedConst',
        'validityConst', 'cTableID', 'groupId', 'linkedId'
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'Type', 'refID', 'cChannel', 'reqValue', 'initValue',
        'schedConst', 'cTableID',
    ];
    
    /**
     * Replaces model attributes by formatted value
     *
     * @return array
     */
    protected function formatFilteredFields() {
        return [
            'Type' => [
                'format' => '{formatted}',
                'value' => function() {
                    return self::$types[$this->Type];
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

    public function reference() {
        return self::$typeToModel[$this->Type]::findOrFail($this->refID);
    }

    public function contextChannelReferenceObject() {
        return $this->morphTo();
    }
}
