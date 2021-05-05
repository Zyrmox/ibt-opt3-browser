<?php

namespace App\Http\Livewire\Molecules;

use App\Models\Opt3\Job;
use App\Models\Opt3\Material;
use App\Models\Opt3\Resource;
use App\Models\Opt3\VP;
use Livewire\Component;

class GlobalSearchBar extends Component
{
    const TOGGLES_SESSION_KEY = 'globalsearch_bar_filters';
    const RESULTS_QUERY_SESSION_KEY = 'globalsearch_bar_results_query';
    const SEARCH_RESULTS_LIMIT = 100;

    public $toggles = [
        'vp' => true,
        'operace' => true,
        'kooperace' => true,
        'zdroje' => true,
        'materiály' => true,
    ];

    private $toggleModel = [
        'vp' => VP::class,
        'operace' => Job::class,
        'kooperace' => Job::class,
        'zdroje' => Resource::class,
        'materiály' => Material::class,
    ];
    
    /**
     * Used for adding additional condition to model's query if model
     * has multiple groups
     *
     * @var array
     */
    protected $additionalModelSearchConditions = [
        // 'toggle' => [
        //     ['model_attribute_name', 'operator', 'value']
        // ],
        
        'operace' => [
            [ 'type', '!=', Job::TYPE_COOPERATION ]
        ],
        'kooperace' => [
            [ 'type', '=', Job::TYPE_COOPERATION ],
        ],
    ];

    public $colors = [
        'vp' => 'yellow-500',
        'operace' => 'theme-500',
        'kooperace' => 'purple-500',
        'zdroje' => 'pink-600',
        'materiály' => 'green-600',
    ];

    public $toggleAll = true;
    public $filters;

    public $search = '';
    public $showResults = false;
    public $results = array();
    public $query = '';

    public $substituted;

    protected $listeners = [
        SubstitutionToggle::ONCHANGED_EVENT_KEY => 'substitutionToggleChanged',
    ];

    public function mount() {
        $this->substituted = SubstitutionToggle::state();
        $this->filters = session(self::TOGGLES_SESSION_KEY, $this->toggles);
    }

    public function substitutionToggleChanged($value) {
        $this->substituted = $value;
    }

    public function search() {
        if ($this->search == '') {
            return;
        }

        $this->results = array();
        foreach ($this->filters as $key => $val) {
            if ($this->filters[$key]) {
                $model = app($this->toggleModel[$key]);

                if (isset($this->additionalModelSearchConditions) && array_key_exists($key, $this->additionalModelSearchConditions)) {
                    $subquery = $model->search($model->getKeyName(), $this->search);

                    foreach($this->additionalModelSearchConditions[$key] as $index => $condition) {
                        $subquery = $subquery->where($condition[0], $condition[1], $condition[2]);
                    }

                    $this->results[$key] = $subquery->limit(self::SEARCH_RESULTS_LIMIT)->get()->toArray();
                } else {
                    $this->results[$key] = $model->search($model->getKeyName(), $this->search)->limit(self::SEARCH_RESULTS_LIMIT)->get()->toArray();
                }
                
            }
        }

        $this->storeResults();
        $this->query = $this->search;
    }

    public function updatingShowResults($value) {
        if ($value == true && $value != $this->showResults) {
            $this->search = session(self::RESULTS_QUERY_SESSION_KEY, '');
            $this->search();
            $this->search = '';
            $this->showResults = false;
        }
    }

    public function toggleAllFilters() {
        $this->toggleAll = !$this->toggleAll;
        foreach ($this->filters as $key => $val) {
            $this->filters[$key] = $this->toggleAll;
        }
        $this->storeFilterValues();
    }

    public function toggleFilter($name) {
        if (!array_key_exists($name, $this->filters)) {
            return;
        }

        $this->filters[$name] = !$this->filters[$name];
        $this->storeFilterValues();
    }

    private function storeFilterValues() {
        session([self::TOGGLES_SESSION_KEY => $this->filters]);
    }

    private function storeResults() {
        session([self::RESULTS_QUERY_SESSION_KEY => $this->search]);
    }

    public function render()
    {
        return view('livewire.molecules.global-search-bar');
    }
}
