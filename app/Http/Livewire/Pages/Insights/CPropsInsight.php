<?php
/**
 * Livewire Fullpage Component Controller - Displays all Context channels (CProp)
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\CProp;
use Livewire\Component;
use Livewire\WithPagination;

class CPropsInsight extends Component
{
    use WithPagination;

    public $currentUrl;
    public $expandableCardInitialState = true;
    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

    const TYPE_ALL = 'all';
    const TYPE_OPERATIONS = 'operations';
    const TYPE_RESOURCE_MACHINES = 'machines';
    const TYPE_RESOURCE_TOOLS = 'tools';

    public $filterByType = self::TYPE_ALL;

    static $typesToggle = [
        self::TYPE_OPERATIONS => 'Typ operace',
        self::TYPE_RESOURCE_MACHINES => 'Typ stroj',
        self::TYPE_RESOURCE_TOOLS => 'Typ nástroj',
        self::TYPE_ALL => 'Vše'
    ];

    protected $toggleToTypeCast = [
        self::TYPE_OPERATIONS => CProp::TYPE_OPERATION,
        self::TYPE_RESOURCE_MACHINES => CProp::TYPE_RESOURCE_MACHINE,
        self::TYPE_RESOURCE_TOOLS => CProp::TYPE_RESOURCE_TOOL
    ];

    /**
     * Automatically generate and manage query strings per defined variables
     *
     * @var array
     */
    protected $queryString = [
        'paginationCount' => ['except' => self::PAGINATION_DEFAULT_COUNT],
        'filterByType' => ['except' => self::TYPE_ALL],
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
        $this->currentUrl = url()->current();
        navigation()->clear();

        $this->substituted = SubstitutionToggle::state();
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

    public function render()
    {
        if ($this->filterByType != self::TYPE_ALL) {
            $data["cprops"] = CProp::where('type', $this->toggleToTypeCast[$this->filterByType])->paginate($this->paginationCount);
        } else {
            $data["cprops"] = CProp::paginate($this->paginationCount);
        }
        
        return view('livewire.pages.insights.cprops-insight', $data);
    }
}
