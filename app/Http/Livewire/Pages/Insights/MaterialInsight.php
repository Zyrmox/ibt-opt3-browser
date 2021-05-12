<?php
/**
 * Livewire Fullpage Component Controller - Displays Specific Material
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Helpers\UserNavigationHistory;
use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\Material;
use Livewire\Component;

class MaterialInsight extends Component
{
    public $material;
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
        $this->material = Material::findOrFail($id);
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
        return view('livewire.pages.insights.material-insight');
    }
}
