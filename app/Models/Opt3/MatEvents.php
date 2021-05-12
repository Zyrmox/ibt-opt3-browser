<?php
/**
 * Material Events Model - representing table "MatEvents"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\HasDBFileConnection;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatEvents extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Filterable;

    const TYPE_SUPPLY = 0;
    const TYPE_PRODUCTION = 1;
    const TYPE_CONSUMPTION = 2;
    const TYPE_ACCESSIBILITY = 3;

    static $types = [
        self::TYPE_SUPPLY => 'Dodávka do skladu',
        self::TYPE_PRODUCTION => 'Produkce',
        self::TYPE_CONSUMPTION => 'Konzumace',
        self::TYPE_ACCESSIBILITY => 'Neomezená dostupnost',
    ];

    protected $connection = 'tenant';
    protected $table = 'matevents';
    protected $keyType = 'string';

    protected $fillable = [
        'sId', 'type', 'whouseID', 'jobId',
        'Amount', 'tmConst'
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'type', 'whouseID', 'jobId',
        'Amount', 'tmConst'
    ];

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
            'tmConst' => [
                'format' => '{formatted}',
                'value' => function() {
                    return Carbon::parse($this->tmConst)->format("d.m.Y h:i:s");
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
        return "mat_event";
    }
    
    /**
     * Returns operation, that is creating the material event
     *
     * @return void
     */
    public function job() {
        return $this->belongsTo(Job::class, 'jobId');
    }
}
