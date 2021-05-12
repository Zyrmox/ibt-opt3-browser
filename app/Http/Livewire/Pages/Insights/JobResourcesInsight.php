<?php
/**
 * Livewire Fullpage Component Controller - Displays Job - Resource requests
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Job;
use Livewire\Component;
use Livewire\WithPagination;

class JobResourcesInsight extends Component
{
    use WithPagination;

    public $substituted;

    const PAGINATION_DEFAULT_COUNT = 25;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;

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

    public function render()
    {
        return view('livewire.pages.insights.job-resources-insight', [
            'fullJobs' => Job::fullOps()->paginate($this->paginationCount),
        ]);
    }
}
