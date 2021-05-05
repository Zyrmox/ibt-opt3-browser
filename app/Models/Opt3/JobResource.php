<?php

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

    protected $fillable = [
        'ressid', 'jobsId', 'mode', 'priority',
        'contextCode', 'iCap', 'dCap',
    ];
}
