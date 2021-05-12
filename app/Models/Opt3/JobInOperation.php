<?php
/**
 * Job In Operation Model - representing pivot table "JobInOperation"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\HasDBFileConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobInOperation extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Filterable;

    const TYPE_SEMI_FINISHED = 0;
    const TYPE_CURRENTLY_RUNNING = 1;

    protected $connection = 'tenant';
    protected $table = 'jobinoperation';
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'type', 'jobsId', 'ressId', 'amount', 'tmConst'
    ];
    
    /**
     * Returns semi finished operations
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function semiFinishedOperations() {
        return self::query()->where('type', self::TYPE_SEMI_FINISHED);
    }
    
    /**
     * Returns currently running operations
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function runningOperations() {
        return self::query()->where('type', self::TYPE_CURRENTLY_RUNNING);
    }
}
