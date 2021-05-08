<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\VP;
use Livewire\Component;
use Livewire\WithPagination;

class VPDeadlinesInsight extends Component
{
    use WithPagination;

    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

    public $filterByType = self::FILTER_ALL;
    public $sortByDate = self::SORT_BY_DATE_OLDEST;

    public $recordsPerManufOrder;
    public $totalRecordsPerManufOrder;

    const FILTER_ALL = 'all-deadlines';
    const FILTER_DUE = 'future-deadlines';
    const FILTER_PAST_DUE = 'past-deadlines';

    const SORT_BY_DATE_OLDEST = 'asc';
    const SORT_BY_DATE_NEWEST = 'desc';

    static $typesToggle = [
        self::FILTER_PAST_DUE => 'Termín deadlinu v minulosti',
        self::FILTER_DUE => 'Termín deadlinu v budoucnosti',
        self::FILTER_ALL => 'Všechny deadliny',
    ];

    static $dateSortingToggle = [
        self::SORT_BY_DATE_OLDEST => 'Od nejvzdálenějších termínů',
        self::SORT_BY_DATE_NEWEST => 'Od nejbližších termínů'
    ];

    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'filterByType' => ['except' => self::FILTER_ALL],
        'sortByDate' => ['except' => self::SORT_BY_DATE_OLDEST]
    ];

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];
    
    public function mount() {
        $this->substituted = SubstitutionToggle::state();
        $this->recordsPerManufOrder = VP::deadlinesWithCount()->get()->values()->pluck('deadline')->flip()->map(function(){
            return 25;
        });
        $this->totalRecordsPerManufOrder = VP::deadlinesWithCount()->get()->values()->pluck('vps_count', 'deadline');
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function updatedPaginationCount() {
        $this->resetPage();
    }

    public function updatedFilterByType() {
        $this->resetPage();
    }

    public function updatePerManufOrderListAmount($deadline) {
        $this->recordsPerManufOrder->put($deadline, $this->recordsPerManufOrder->get($deadline) + 25);
    }

    public function getTotalManufOrderRecordsCount($deadline) {
        return (int) $this->totalRecordsPerManufOrder->get($deadline);
    }

    public function render()
    {
        if ($this->filterByType == self::FILTER_PAST_DUE) {
            $data["deadlines"] = VP::missedDeadlines()->orderBy('deadline', $this->sortByDate)->paginate($this->paginationCount);
        } else if ($this->filterByType == self::FILTER_DUE) {
            $data["deadlines"] = VP::futureDeadlines()->orderBy('deadline', $this->sortByDate)->paginate($this->paginationCount);
        } else {
            $data["deadlines"] = VP::deadlines()->orderBy('deadline', $this->sortByDate)->paginate($this->paginationCount);
        }

        return view('livewire.pages.insights.vp-deadlines-insight', $data);
    }
}
