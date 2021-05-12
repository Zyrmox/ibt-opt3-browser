<?php
/**
 * Material Model - representing table "Materials"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\GloballySearchable;
use App\Traits\HasDBFileConnection;
use App\Traits\Namable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Material extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Namable,
        Filterable,
        GloballySearchable;

    protected $connection = 'tenant';
    protected $table = 'materials';
    protected $primaryKey = 'sId';
    protected $keyType = 'string';

    protected $fillable = [
        'sId', 'whouseID', 'type', 'amount',
        'matCapacity',
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'sId', 'whouseID', 'type', 'amount', 'matCapacity', 
    ];

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
        return "materiál";
    }
    
    /**
     * Return all Warehouses with number of types of material 
     * that is stored inside this warehouse
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function allWareHouses() {
        return DB::connection('tenant')
            ->table('materials')
            ->select('whouseID', DB::raw('COUNT(whouseID) as count'))
            ->groupBy('whouseID');
    }

    /**
     * Return all Warehouses with number of types of material 
     * that is stored inside this warehouse
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function wareHouses() {
        return DB::connection('tenant')
            ->table('materials')
            ->select('whouseID')
            ->where('sId', $this->sId);
    }

    /**
     * Return all Material model instances stored inside specified warehouse
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function materialsInWarehouse($warehouse) {
        return static::query()
            ->where('whouseID', $warehouse);
    }

    /**
     * Return all Material model instances groupped by warehouses
     *
     * @return Collection
     */
    public static function grouppedByWarehouse() {
        $warehouses = static::wareHouses()->get();
        $results = array();
        foreach($warehouses as $wh) {
            $results[$wh->whouseID] = static::materialsInWarehouse($wh->whouseID)->get();
        }
        return collect($results);
    }
    
    /**
     * Check whether Material has some amount
     *
     * @return void
     */
    public function hasSomeAmount() {
        return $this->amount != 0;
    }
    
    /**
     * Return formatted material amount, rounded to two decimal places
     *
     * @return void
     */
    public function amount() {
        return round($this->amount, 2);
    }

    /**
     * Return all Material events linked with this model's instance
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function matEvents($type = null) {
        $query = $this->hasMany(MatEvents::class, 'sId', 'sId');
        return $type == null
            ? $query
            : $query->where('type', $type);
    }
}
