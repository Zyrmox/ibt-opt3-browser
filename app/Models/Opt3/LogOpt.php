<?php
/**
 * Log Opt Model - representing settings of optimalization software from "LogOpts" table
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogOpt extends Model
{
    use HasFactory, Filterable;

    protected $connection = 'tenant';
    protected $table = 'logopts';
    protected $primaryKey = 'optChar';
    protected $keyType = 'string';

    const OPTION_DEFAULT_TYPE = 3;
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'optChar', 'optValue'
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'optChar', 'optValue'
    ];
    
    /**
     * Returns all options from database
     *
     * @return App\Models\Opt3\LogOpt
     */
    public static function allOpts() {
        return self::where('type', self::OPTION_DEFAULT_TYPE);
    }
}
