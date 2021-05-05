<?php

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
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'optChar', 'optValue'
    ];

    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    protected $filterable = [
        'optChar', 'optValue'
    ];

    public static function allOpts() {
        return self::where('type', 3);
    }
}
