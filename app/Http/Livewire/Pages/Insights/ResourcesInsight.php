<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Resource;
use Livewire\Component;
use Livewire\WithPagination;

class ResourcesInsight extends Component
{
    use WithPagination;

    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;
    
    const TYPE_ALL = 'all';
    const TYPE_MACHINES = 'machines';
    const TYPE_PERSONNEL = 'personnel';
    const TYPE_TOOLS = 'tools';

    /**
     * Sorting toggle toggle values
     *
     * @var mixed
     */
    static $typesToggle = [
        self::TYPE_MACHINES => 'Zdroje typu stroj',
        self::TYPE_PERSONNEL => 'Zdroje typu personál',
        self::TYPE_TOOLS => 'Zdroje typu nástroj',
        self::TYPE_ALL => 'Všechny zdroje',
    ];

    protected $toggleToTypeCast = [
        self::TYPE_MACHINES => Resource::TYPE_MACHINE,
        self::TYPE_PERSONNEL => Resource::TYPE_PERSONNEL,
        self::TYPE_TOOLS => Resource::TYPE_TOOL,
        self::TYPE_TOOLS => Resource::TYPE_TOOL,
    ];

    /**
     * Sorting toggle value
     */
    public $filterByType = self::TYPE_ALL;

    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'filterByType' => ['except' => self::TYPE_ALL],
    ];

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];
    
    public function mount() {
        $this->substituted = SubstitutionToggle::state();
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function updatedPaginationCount() {
        $this->resetPage();
    }

    public function updatedFilterByType($value) {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->filterByType != self::TYPE_ALL) {
            $data["resources"] = Resource::where('type', $this->toggleToTypeCast[$this->filterByType])->paginate($this->paginationCount);
        } else {
            $data["resources"] = Resource::paginate($this->paginationCount);
        }
        return view('livewire.pages.insights.resources-insight', $data);
    }
}
