<?php

namespace App\Models\Opt3;

use App\Traits\Namable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Warehouse extends Model
{
    use HasFactory,
        Namable;

    public $sId;
    public $shortId;

    public function __construct($whouseID)
    {
        $this->sId = $whouseID;
        $this->shortId = shortId()->trans(Auth::user()->databaseFiles()->first()->url, $this->sId, $this->setSubstitutionGroup(), self::class);
    }

    /**
     * Set substitution group name to be used in short_id table
     *
     * @return string
     */
    public function setSubstitutionGroup()
    {
        return "sklad";
    }
}
