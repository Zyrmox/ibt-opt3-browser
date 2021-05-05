<?php

namespace App\Http\Livewire\Pages\Insights;

use App\Http\Livewire\Molecules\SubstitutionToggle;
use App\Models\Opt3\ResCalendar;
use App\Models\Opt3\Resource;
use Livewire\Component;
use Livewire\WithPagination;

class ResourceInsight extends Component
{
    use WithPagination;

    public $resource;
    public $substituted;

    public $calendar;
    const PAGINATION_DEFAULT_COUNT = 10;
    public $paginationCount = self::PAGINATION_DEFAULT_COUNT;
    public $search = '';
    public $date;

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];

    public function mount($id)
    {
        $this->resource = Resource::findOrFail($id);
        $this->substituted = SubstitutionToggle::state();
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function updatedSearch()
    {
        $this->resetPage();
        if (preg_match('/(0?[1-9]|[12][0-9]|3[01])\. ?(0?[1-9]|1[0-2])\. ?(20[0-9]{2})?/', $this->search, $matches)) {
            array_shift($matches);
            for ($i = 0; $i < 2; $i++) {
                if (strlen((string)$matches[$i]) < 2) {
                    $matches[$i] = '0' . $matches[$i];
                }
            }
            $arr = array_reverse($matches);
            $this->date = implode('-', $arr);
        } else {
            $this->date = $this->search;
        }
    }

    public function updatedPaginationCount()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.pages.insights.resource-insight', [
            'calendarRecords' => ResCalendar::search('tstart', $this->date)->where('ressId', $this->resource->sId)->paginate($this->paginationCount),
        ]);
    }
}
