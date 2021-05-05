<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Job;
use Livewire\Component;
use Livewire\WithPagination;

class Jobs extends Component
{
    use WithPagination;

    public $currentUrl;
    public $expandableCardInitialState = true;
    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

    const TYPE_ALL = 'all';
    const TYPE_FULL_OPS = 'full-ops';
    const TYPE_COOPS = 'coops';

    public $filterByType = self::TYPE_ALL;

    static $typesToggle = [
        self::TYPE_FULL_OPS => 'Plné operace',
        self::TYPE_COOPS => 'Kooperace',
        self::TYPE_ALL => 'Vše',
    ];

    protected $toggleToTypeCast = [
        self::TYPE_FULL_OPS => Job::TYPE_FULL_OP,
        self::TYPE_COOPS => Job::TYPE_COOPERATION
    ];

    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'filterByType' => ['except' => self::TYPE_ALL],
    ];

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];
    
    public function mount() {
        $this->currentUrl = url()->current();
        navigation()->clear();

        $this->substituted = SubstitutionToggle::state();
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

    public function render()
    {
        if ($this->filterByType != self::TYPE_ALL) {
            $data["operations"] = Job::where('type', $this->toggleToTypeCast[$this->filterByType])->paginate($this->paginationCount);
        } else {
            $data["operations"] = Job::fullOpsAndCoops()->paginate($this->paginationCount);
        }
        return view('livewire.pages.insights.jobs', $data);
    }
}
