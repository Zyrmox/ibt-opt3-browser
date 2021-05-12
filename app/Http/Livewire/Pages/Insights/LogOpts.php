<?php
/**
 * Livewire Fullpage Component Controller - Displays All Options (Settings of scheduling software)
 *
 * @author Petr Vrtal <xvrtal01@fit.vutbr.cz>
 */
namespace App\Http\Livewire\Pages\Insights;

use App\Models\Opt3\LogOpt;
use Livewire\Component;
use Livewire\WithPagination;

class LogOpts extends Component
{
    use WithPagination;

    public $currentUrl;
    public $search = '';

    public $attributes;
    public $logOpts;

    public function updatedSearch() {
        $this->fetchLogOpts();
    }
    
    /**
     * Gets called on component mount
     *
     * @return void
     */
    public function mount() {
        $this->currentUrl = url()->current();
        navigation()->clear();

        $this->attributes = LogOpt::allOpts()->first()->exists() ? LogOpt::all()->first()->getFilteredAttributes() : [];
        $this->fetchLogOpts();
    }

    private function fetchLogOpts() {
        $this->logOpts = LogOpt::allOpts()->where('optChar', 'like', '%' . $this->search . '%')->get();
    }

    public function render()
    {
        return view('livewire.pages.insights.log-opts');
    }
}
