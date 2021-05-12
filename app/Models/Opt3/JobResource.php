<?php
/**
 * Job Resource Model - representing pivot table "JobResource"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\HasDBFileConnection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobResource extends Model
{
    use HasFactory, HasDBFileConnection;

    protected $connection = 'tenant';
    protected $table = "JobResource";
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = [
        'ressid', 'jobsId', 'mode', 'priority',
        'contextCode', 'iCap', 'dCap',
    ];
}
