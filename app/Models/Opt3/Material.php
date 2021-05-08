<?php

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

    protected $filterable = [
        'sId', 'whouseID', 'amount', 
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

    public static function allWareHouses() {
        return DB::connection('tenant')
            ->table('materials')
            ->select('whouseID', DB::raw('COUNT(whouseID) as count'))
            ->groupBy('whouseID');
    }

    public function wareHouses() {
        return DB::connection('tenant')
            ->table('materials')
            ->select('whouseID')
            ->where('sId', $this->sId);
    }

    public static function materialsInWarehouse($warehouse) {
        return static::query()
            ->where('whouseID', $warehouse);
    }

    public static function grouppedByWarehouse() {
        $warehouses = static::wareHouses()->get();
        $results = array();
        foreach($warehouses as $wh) {
            $results[$wh->whouseID] = static::materialsInWarehouse($wh->whouseID)->get();
        }
        return collect($results);
    }

    public function hasSomeAmount() {
        return $this->amount != 0;
    }

    public function amount() {
        return round($this->amount, 2);
    }

    public function matEvents($type = null) {
        $query = $this->hasMany(MatEvents::class, 'sId', 'sId');
        return $type == null
            ? $query
            : $query->where('type', $type);
    }
}
