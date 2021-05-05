<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Helpers\UserNavigationHistory;
use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Job;
use Livewire\Component;

class JobInsight extends Component
{
    public $job;
    public $substituted;

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];

    public function mount($id)
    {
        $this->job = Job::findOrFail($id);
        $this->substituted = SubstitutionToggle::state();
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function render()
    {
        return view('livewire.pages.insights.job-insight');
    }
}
