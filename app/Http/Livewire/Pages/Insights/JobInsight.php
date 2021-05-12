<?php
/**
 * Livewire Fullpage Component Controller - Displays Specific Job
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Helpers\UserNavigationHistory;
use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Job;
use Livewire\Component;

class JobInsight extends Component
{
    public $job;
    public $substituted;

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
    public function mount($id)
    {
        $this->job = Job::findOrFail($id);
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

    public function render()
    {
        return view('livewire.pages.insights.job-insight');
    }
}
