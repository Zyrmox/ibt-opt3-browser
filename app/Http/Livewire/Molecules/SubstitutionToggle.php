<?php

namespace App\Http\Livewire\Molecules;

use Livewire\Component;

class SubstitutionToggle extends Component
{
    const SESSION_KEY = "substitutionToggle";
    const ONCHANGED_EVENT_KEY = "substitutionToggleChanged";

    public $substitute;
    
    /**
     * Livewire component mount function
     *
     * @return void
     */
    public function mount() {
        $this->setupSession();
        $this->substitute = session(self::SESSION_KEY);
    }
    
    /**
     * Stores actual state of toggle to session and fires onchanged event
     *
     * @param  mixed $value
     * @return void
     */
    public function updatedSubstitute($value) {
        session([self::SESSION_KEY => $value]);
        $this->emit(self::ONCHANGED_EVENT_KEY, $value);
    }

    private static function setupSession() {
        if (session(self::SESSION_KEY) == null) {
            session([self::SESSION_KEY => false]);
        }
    }
    
    /**
     * Returns actual state of substitution toggle
     *
     * @return bool
     */
    public static function state(): bool {
        self::setupSession();
        return session(self::SESSION_KEY);
    }
    
    /**
     * Returns Livewire event name for onchanged event
     *
     * @return string
     */
    public static function onChangedEventName(): string {
        return self::ONCHANGED_EVENT_KEY;
    }
    
    /**
     * Livewire component render method
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.molecules.substitution-toggle');
    }
}
