<?php
/**
 * Resource Calendar Model - representing table "ResourceCalendar"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\GloballySearchable;
use App\Traits\HasDBFileConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResCalendar extends Model
{
    use HasFactory,
        HasDBFileConnection,
        GloballySearchable,
        Filterable;

    protected $connection = 'tenant';
    protected $table = 'rescalendar';
    protected $keyType = 'string';
    protected $primaryKey = 'ressId';

    protected $fillable = [
        'ressId', 'tstart', 'tend', 'relavail', 'iCap', 'dCap',
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'tstart', 'tend', 'relavail', 'iCap', 'dCap',
    ];

    public static function primaryKey() {
        return (new static())->getKeyName();
    }
}
