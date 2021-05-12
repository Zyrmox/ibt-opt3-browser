<?php
/**
 * Livewire Fullpage Component Controller - Displaying Manufacturing Orders (česky VP)
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\VP;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithPagination;

class VPsInsight extends Component
{
    use WithPagination;

    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

    public $view = self::VIEW_VPS_TABLE;
    public $filterByType = self::FILTER_ALL;
    public $groupByPriority = self::GROUP_BY_PRIORITY_DESC;
    public $disableNonPriority = false;

    public $displayedRecordsPerPriority;
    public $totalRecordsPerPriority;

    const VIEW_VPS_TABLE = 'table';
    const VIEW_VPS_GROUPED_BY_PRIORITY = 'grouped-by-priority';

    const FILTER_ALL = 'all';
    const FILTER_OWNING_FULL_OPS = 'owning-full-ops';
    const FILTER_OWNING_COOPS = 'owning-coops';

    const GROUP_BY_PRIORITY_DESC = 'desc';
    const GROUP_BY_PRIORITY_ASC = 'asc';

    static $typesToggle = [
        self::FILTER_OWNING_FULL_OPS => 'VP obsahující operace',
        self::FILTER_OWNING_COOPS => 'VP obsahující kooperace',
        self::FILTER_ALL => 'Všechny VP',
    ];

    static $viewsToggle = [
        self::VIEW_VPS_TABLE => 'Tabulka VP',
        self::VIEW_VPS_GROUPED_BY_PRIORITY => 'Skupiny VP dle priority',
    ];

    static $groupByPriorityToggle = [
        self::GROUP_BY_PRIORITY_DESC => 'Podle priority sestupně',
        self::GROUP_BY_PRIORITY_ASC => 'Podle priority vzestupně',
    ];
    
    /**
     * Automatically generate and manage query strings per defined variables
     *
     * @var array
     */
    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'view' => ['except' => self::VIEW_VPS_TABLE],
        'filterByType' => ['except' => self::FILTER_ALL],
        'groupByPriority' => ['except' => self::GROUP_BY_PRIORITY_DESC],
        'disableNonPriority' => ['except' => false],
    ];

    /**
     * Listens for these emmited events and calls coresponding class method
     *
     * @var array
     */
    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];
    
    /**
     * Gets called on component mount
     *
     * @return void
     */
    public function mount() {
        $this->substituted = SubstitutionToggle::state();
        $this->displayedRecordsPerPriority = VP::ordersWithCountBasedOnPriority()->get()->values()->pluck('priority')->flip()->map(function(){
            return 25;
        });
        $this->totalRecordsPerPriority = VP::ordersWithCountBasedOnPriority()->get()->values()->pluck('vps_count', 'priority');
    }

    /**
     * Updates substitution toggle value (state),
     *
     * @param  mixed $value new substitution toggle state
     * @return void
     */
    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function updatedPaginationCount() {
        $this->resetPage();
    }

    public function updatedFilterByType() {
        $this->resetPage();
    }

    public function updateRecordsPerPriorityListAmount($priority) {
        $this->displayedRecordsPerPriority->put($priority, $this->displayedRecordsPerPriority->get($priority) + 25);
    }

    public function getTotalRecordsPerPriorityCount($priority) {
        return (int) $this->totalRecordsPerPriority->get($priority);
    }

    public function render()
    {
        if ($this->filterByType == self::FILTER_ALL) {
            $data["vps"] = VP::paginate($this->paginationCount);
        } else if ($this->filterByType == self::FILTER_OWNING_FULL_OPS) {
            $data["vps"] = VP::fullOperations()->paginate($this->paginationCount);
        } else if ($this->filterByType == self::FILTER_OWNING_COOPS) {
            $data["vps"] = VP::cooperations()->paginate($this->paginationCount);
        }

        $groups = VP::groupByPriority($this->groupByPriority);
        if ($this->disableNonPriority) {
            $groups = $groups->filter(function($vp) {
                return intval($vp->first()->priority) > 0;
            });
        }

        $data["groups"] = $groups;

        return view('livewire.pages.insights.vps-insight', $data);
    }
}
