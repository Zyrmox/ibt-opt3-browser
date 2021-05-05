<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Helpers\UserNavigationHistory;
use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Material;
use Livewire\Component;

class MaterialInsight extends Component
{
    public $material;
    public $substituted;

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];

    public function mount($id)
    {
        $this->material = Material::findOrFail($id);
        $this->substituted = SubstitutionToggle::state();
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function render()
    {
        return view('livewire.pages.insights.material-insight');
    }
}
