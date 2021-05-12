<?php
/**
 * Manufacturing Order Model - representing  table "VP"
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Models\Opt3;

use App\Traits\Filterable;
use App\Traits\GloballySearchable;
use App\Traits\HasDBFileConnection;
use App\Traits\Namable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class VP extends Model
{
    use HasFactory,
        HasDBFileConnection,
        Namable,
        Filterable,
        GloballySearchable;

    protected $connection = 'tenant';
    protected $table = 'vp';
    protected $primaryKey = 'sId';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sId', 'deadline', 'lrjs', 'matStrat',
        'priority',
    ];

    /**
     * Replaces model attributes by formatted value
     *
     * @return array
     */
    protected function formatFilteredFields() {
        return [
            'deadline' => [
                'format' => '{formatted}',
                'value' => function () {
                    return dateFromDateTime($this->deadline);
                },
            ],
        ];
    }
    
    /**
     * Returns primary key name
     *
     * @return string
     */
    public static function primaryKey() {
        return (new static)->getKeyName();
    }
    
    /**
     * Selects distinct deadlines from vp table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function deadlines() {
        return self::select('deadline')
            ->groupBy('deadline');
    }
    
    /**
     * Selects distinct missed deadlines from vp table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function missedDeadlines() {
        return self::query()
            ->select('deadline')
            ->whereDate('deadline', '<', Carbon::today()->toDateString())
            ->groupBy('deadline');
    }

    /**
     * Selects distinct deadlines in the future from vp table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function futureDeadlines() {
        return self::query()
            ->select('deadline')
            ->whereDate('deadline', '>', Carbon::today()->toDateString())
            ->groupBy('deadline');
    }

    /**
     * Selects rows with already passed deadlines from vp table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withMissedDeadlines() {
        return self::query()
            ->whereDate('deadline', '<', Carbon::today()->toDateString());
    }

    /**
     * Selects rows with deadlines set in future from vp table
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withFutureDeadlines() {
        return self::query()
            ->whereDate('deadline', '>', Carbon::today()->toDateString());
    }
    
    /**
     * Groups rows by its priority in groups
     *
     * @param string $sorting sorting of group, either 'asc' or 'desc'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function groupByPriority($sorting) {
        return self::query()
            ->orderBy('priority', $sorting)
            ->get()
            ->groupBy('priority');
    }

    /**
     * Returns manufacturing order's entity count based on its priority
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function ordersWithCountBasedOnPriority() {
        return self::select('priority', DB::raw('COUNT(priority) as vps_count'))
            ->groupBy('priority');
    }
    
    /**
     * Returns rows with specified priority
     *
     * @param  int $priority
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withPriority(int $priority) {
        return self::where('priority', $priority);
    }
    
    /**
     * Returns all rows with specified deadline
     *
     * @param  mixed $deadline
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function whereDeadline($deadline) {
        return VP::where('deadline', '=', $deadline);
    }
    
    /**
     * Return true if deadline is past today's date
     *
     * @return bool
     */
    public function isDeadlinePastDue(): bool {
        return Carbon::parse($this->deadline)->lessThan(Carbon::today()->toDateString());
    }

    /**
     * Get full operations relative to class instance
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function relFullOperations() {
        return Job::query()
            ->join('ownership', 'ownership.tobjsid', 'jobs.sId')
            ->select('jobs.*')
            ->where('ownership.fobjsid', parent::__get('sId'))
            ->where('jobs.type', Job::TYPE_FULL_OP)
            ->get();
    }

    /**
     * Returns cooperations relative to class instance
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function relCooperations() {
        return Job::query()
            ->join('ownership', 'ownership.tobjsid', 'jobs.sId')
            ->select('jobs.*')
            ->where('ownership.fobjsid', parent::__get('sId'))
            ->where('jobs.type', Job::TYPE_COOPERATION)
            ->get();
    }
    
    /**
     * Returns full operations in Eloquet builder class instance
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function fullOperations() {
        return self::query()
            ->join('ownership', 'ownership.fobjsid', 'vp.sId')
            ->join('jobs', 'ownership.tobjsid', 'jobs.sId')
            ->select('vp.*')
            ->where('jobs.type', Job::TYPE_FULL_OP);
    }

    /**
     * Returns cooperations in Eloquet builder class instance
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function cooperations() {
        return self::query()
            ->join('ownership', 'ownership.fobjsid', 'vp.sId')
            ->join('jobs', 'ownership.tobjsid', 'jobs.sId')
            ->select('vp.*')
            ->where('jobs.type', Job::TYPE_COOPERATION);
    }
    
    /**
     * Returns all resources used by operations and cooperations relative to class instance
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function resources() {
        $resources = array();
        foreach ($this->relFullOperations() as $op) {
            foreach($op->resources() as $resource) {
                if (!in_array ($resource, $resources, true)) {
                    array_push($resources, $resource);
                }
            }
            foreach($op->phaseOperations() as $phase) {
                foreach($phase->resources() as $phase_res) {
                    if (!in_array ($phase_res, $resources, false)) {
                        array_push($resources, $phase_res);
                    }
                }
            }
        }
        return collect($resources);
    }
    
    /**
     * Returns deadlines with count of related VPs
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function deadlinesWithCount() {
        return self::select('deadline', DB::raw('COUNT(deadline) as vps_count'))
            ->groupBy('deadline');
    }
}
