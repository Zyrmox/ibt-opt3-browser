<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Material;
use App\Models\Opt3\MatEvents;
use Livewire\Component;
use Livewire\WithPagination;

class MaterialsInsight extends Component
{
    use WithPagination;

    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

    public $view = self::VIEW_MATERIALS_TABLE;
    public $groupByAmount = self::GROUP_BY_DESC;
    public $groupByMaterialsCount = self::GROUP_BY_DESC;

    const VIEW_MATERIALS_TABLE = 'materials-table';
    const VIEW_WAREHOUSES_TABLE = 'warehouses-table';

    const GROUP_BY_DESC = 'desc';
    const GROUP_BY_ASC = 'asc';

    static $viewsToggle = [
        self::VIEW_MATERIALS_TABLE => 'Tabulka Materiálů',
        self::VIEW_WAREHOUSES_TABLE => 'Tabulka skladů',
    ];

    static $groupByAmountToggle = [
        self::GROUP_BY_DESC => 'Podle množství sestupně',
        self::GROUP_BY_ASC => 'Podle množství vzestupně',
    ];

    static $groupByMaterialsCountToggle = [
        self::GROUP_BY_DESC => 'Podle množství materiálu ve skladě sestupně',
        self::GROUP_BY_ASC => 'Podle množství materiálu ve skladě vzestupně',
    ];

    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'view' => ['except' => self::VIEW_MATERIALS_TABLE],
        'groupByAmount' => ['except' => self::GROUP_BY_DESC],
        'groupByMaterialsCount' => ['except' => self::GROUP_BY_DESC],
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

    public function updatedGroupByAmount() {
        $this->resetPage();
    }

    public function updatedView() {
        $this->resetPage();
    }

    public function viewIs($viewName) {
        return $this->view == $viewName;
    }

    public function render()
    {
        $materials = Material::groupBy('sId')->orderBy('amount', $this->groupByAmount)->paginate($this->paginationCount);

        $warehouses = Material::allWareHouses()->paginate($this->paginationCount);
        foreach($warehouses as $index => $warehouse) {
            $warehouse->materials = Material::materialsInWarehouse($warehouse->whouseID)->paginate($this->paginationCount, ['*'], 'warehouse' . $index . 'Page');
            // $warehouse->materials = Material::materialsInWarehouse($warehouse->whouseID)->paginate($this->paginationCount);
            // $warehouse->materials->setPageName('warehouse' . $index . 'Page');
        }
        return view('livewire.pages.insights.materials-insight', [
            'materials' => $materials,
            'warehouses' => $warehouses,
        ]);
    }
}
