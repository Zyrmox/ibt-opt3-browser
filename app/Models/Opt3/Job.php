<?php
/**
 * Job Model - representing data from "jobs" table
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\GloballySearchable;
use App\Traits\HasContextChannels;
use App\Traits\Namable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory,
        Namable,
        Filterable,
        GloballySearchable,
        HasContextChannels;

    /* Specifies database connection interface to be used for querying */
    protected $connection = 'tenant';
    protected $primaryKey = 'sId';
    protected $keyType = 'string';

    /* All possible types (forms) of Job in manufacturing task */
    const TYPE_ALL = -1;
    const TYPE_FULL_OP = 0;
    const TYPE_PHASE_OP_INST = 2;
    const TYPE_PHASE_OP_ROZJ = 3;
    const TYPE_PHASE_OP_ITER = 4;
    const TYPE_PHASE_OP_FIN = 5;
    const TYPE_MAINTANANCE = 6;
    const TYPE_COOPERATION = 7;

    /**
     * Types to names (string) mapping
     *
     * @var array
     */
    static $types = [
        self::TYPE_FULL_OP => [
            'cathegory' => 'Plná operace',
            'full' => 'Plná operace'
        ],
        self::TYPE_PHASE_OP_INST => [
            'cathegory' => 'Fázová operace',
            'full' => 'Instalace',
            'short' => 'Inst'
        ],
        self::TYPE_PHASE_OP_ROZJ => [
            'cathegory' => 'Fázová operace',
            'full' => 'Rozjezd',
            'short' => 'Rozj'
        ],
        self::TYPE_PHASE_OP_ITER => [
            'cathegory' => 'Fázová operace',
            'full' => 'Výroba',
            'short' => 'Iter'
        ],
        self::TYPE_PHASE_OP_FIN => [
            'cathegory' => 'Fázová operace',
            'full' => 'Dokončení',
            'short' => 'Fin'
        ],
        self::TYPE_MAINTANANCE => [
            'cathegory' => 'Údržba',
            'full' => 'Údržba'
        ],
        self::TYPE_COOPERATION => [
            'cathegory' => 'Kooperace',
            'full' => 'Kooperace'
        ],
    ];

    static $basicOpTypes = [
        self::TYPE_FULL_OP => 'Plná operace',
        self::TYPE_PHASE_OP_INST => 'Instalace',
        self::TYPE_PHASE_OP_ROZJ => 'Rozjezd',
        self::TYPE_PHASE_OP_ITER => 'Výroba',
        self::TYPE_PHASE_OP_FIN => 'Dokončení',
        self::TYPE_MAINTANANCE => 'Údržba',
        self::TYPE_COOPERATION => 'Kooperace',
    ];

    static $phaseOpsTypes = [
        self::TYPE_PHASE_OP_INST,
        self::TYPE_PHASE_OP_ROZJ,
        self::TYPE_PHASE_OP_ITER,
        self::TYPE_PHASE_OP_FIN,
    ];
    
    protected $color = 'theme-500';
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sId', 'type', 'alternativeNumber', 'jobColor',
        'duration', 'amount', 'amountPackage', 'amountPerCycle',
        'transportTime', 'productsId', 'standingTime', 'rmOptions'
    ];

    /**
     * Attributes to be filtered using Filterable trait
     *
     * @var array
     */
    protected $filterable = [
        'sId', 'type', 'amount', 'productsId', 'standingTime',
    ];

    /**
     * Set substitution group name to be used in short_id table
     * overshadowing method from trait Namable
     *
     * @return string
     */
    public function setSubstitutionGroup()
    {
        return str_replace(' ', '_', mb_strtolower($this->getTypeName(), 'UTF-8'));
    }

    /**
     * Set substitution position aka index to be used in short_id table
     * overshadowing method from trait Namable
     *
     * @return string
     */
    public function setSubstitutionPosition()
    {
        if (!$this->isFullOp()) {
            return self::
                whereIn('type', [self::TYPE_PHASE_OP_FIN, self::TYPE_PHASE_OP_INST, self::TYPE_PHASE_OP_ITER, self::TYPE_PHASE_OP_ROZJ])
                ->get()->search(function ($model, $key) {
                    return $model->sId == $this->sId;
                }) + 1;
        }
        return self::where('type', $this->type)->get()->search(function ($model, $key) {
            return $model->sId == $this->sId;
        }) + 1;
    }

    /**
     * Replaces model attributes by formatted value
     *
     * @return array
     */
    protected function formatFilteredFields() {
        return [
            'type' => [
                'format' => '{formatted}',
                'value' => function() {
                    return self::$basicOpTypes[$this->type];
                }
            ],
        ];
    }
    
    /**
     * Returns model instance primary key
     *
     * @return static
     */
    public static function primaryKey() {
        return (new static)->getKeyName();
    }
    
    /**
     * Returns all instances of type Full operation and Cooperation
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function fullOpsAndCoops() {
        return self::query()
            ->where('type', self::TYPE_FULL_OP)
            ->orWhere('type', self::TYPE_COOPERATION);
    }
    
    /**
     * Returns collection of all instances with Phase operation type
     *
     * @return Collection
     */
    public function phaseOperations() {
        return self::query()
            ->join('ownership', 'ownership.tobjsid', 'jobs.sId')
            ->select('jobs.*')
            ->where('ownership.fobjsid', parent::__get('sId'))
            ->get();
    }
    
    /**
     * Returns collection of all instances with Full operation type
     *
     * @return Collection
     */
    public function fullOperation() {
        return self::query()
            ->join('ownership', 'ownership.fobjsid', 'jobs.sId')
            ->select('jobs.*')
            ->where('ownership.tobjsid', parent::__get('sId'))
            ->get();
    }
    
    /**
     * Returns all Manufacturing orders with relation to this model's instance
     *
     * @return void
     */
    public function VPs() {
        return VP::query()
            ->join('ownership', 'ownership.fobjsid', 'vp.sId')
            ->select('vp.*')
            ->where('ownership.tobjsid', parent::__get('sId'))
            ->get();
    }

    /**
     * Returns collection of all model instances with type Full operation
     *
     * @return Collection
     */
    public static function fullOps() {
        return Job::where('type', self::TYPE_FULL_OP);
    }
    
    /**
     * Returns collection of JobResource models record with relation to this model's instance
     *
     * @return Collection
     */
    public function jobResources() {
        return self::query()
            ->join('jobresource', 'jobresource.jobsId', 'jobs.sId')
            ->join('resources', 'jobresource.ressId', 'resources.sId')
            ->select([
                'resources.*',
                'jobresource.*'
            ])
            ->where('jobresource.jobsId', parent::__get('sId'))
            ->get();
    }
    
    /**
     * Returns operation's status from JobInOperation table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations() {
        return $this->hasMany(JobInOperation::class, 'jobsId', 'sId');
    }
    
    /**
     * Returns collection of all Resources model instances with relation to this model's instance
     *
     * @return Collection
     */
    public function resources() {
        return Resource::query()
            ->join('jobresource', 'jobresource.ressid', 'resources.sId')
            ->select('resources.*')
            ->where('jobresource.jobsId', parent::__get('sId'))
            ->get();
    }
    
    /**
     * Check job type
     *
     * @param  mixed $type
     * @return void
     */
    public function ofType($type) {
        return $this->type == $type;
    }
    
    /**
     * Returns query for all operations of certain type
     *
     * @param  mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getOpsOfType($type) {
        return self::query()
            ->where('type', $type);
    }
    
    /**
     * Type to name mapping
     *
     * @return string
     */
    public function getTypeName() {
        return self::$types[$this->type]["cathegory"];
    }
    
    /**
     * Check, whether operation is full or not
     *
     * @return bool
     */
    public function isFullOp() : bool {
        return $this->type == 0;
    }

    /**
     * Check, whether operation is phase operation
     *
     * @return bool
     */
    public function isPhaseOp() : bool {
        return in_array(intval($this->type), self::$phaseOpsTypes, true);
    }

    /**
     * Check, whether operation is cooperation
     *
     * @return bool
     */
    public function isCoop(): bool {
        return $this->type == self::TYPE_COOPERATION;
    }

    /**
     * Returns operation cathegory name
     *
     * @return string
     */
    public function opCathegory() : string {
        return self::$types[$this->type]["cathegory"];
    }

    /**
     * Returns operation type
     *
     * @return string
     */
    public function opType() : string {
        return self::$types[$this->type]["full"];
    }

    /**
     * Returns short representation of operation type 
     *
     * @return string
     */
    public function opTypeShort() : string {
        return self::$types[$this->type]["short"] ? self::$types[$this->type]["short"] : $this->opType();
    }

    /**
     * Returns coresponding text color
     *
     * @return string
     */
    public function color() {
        return 'text-' . $this->color;
    }
}
