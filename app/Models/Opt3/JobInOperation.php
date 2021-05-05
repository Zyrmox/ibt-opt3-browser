<?php

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

    protected $fillable = [
        'type', 'jobsId', 'ressId', 'amount', 'tmConst'
    ];

    public static function semiFinishedOperations() {
        return self::query()->where('type', self::TYPE_SEMI_FINISHED);
    }

    public static function runningOperations() {
        return self::query()->where('type', self::TYPE_CURRENTLY_RUNNING);
    }
}
