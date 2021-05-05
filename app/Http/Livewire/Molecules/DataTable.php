<?php

namespace App\Http\Livewire\Molecules;

use Livewire\Component;

class DataTable extends Component
{
    public $substitutable;
    public $sortable;
    public $searchable;

    public $cols;
    public $data;

    public $substituted = true;

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];

    public function mount($substitutable = null, $sortable = null, $searchable = null, $data, $cols)
    {
        $this->substitutable = $substitutable ?? false;
        $this->sortable = $sortable ?? false;
        $this->searchable = $searchable ?? false;

        $this->cols = $cols;
        $this->data = $data;
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function render()
    {
        return view('livewire.molecules.data-table');
    }
}
