<div>
    <!--
        Substitution Toggle - Livewire Component
        Controller for this component: App/Http/Livewire/Molecules/SubstitutionToggle.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <div class="flex items-center ml-auto">
        <div x-data="{ toggled: @entangle('substitute') }"
            class="cursor-pointer w-12 h-7 flex items-center bg-gray-300 rounded-full p-1 duration-300 ease-in-out shadow-inner"
            x-bind:class="{ 'bg-green-400': toggled }" @click="toggled = !toggled">

            <!-- Switch -->
            <div class="bg-white w-5 h-5 rounded-full shadow-md transform duration-150 ease-in-out" x-bind:class="{ 'translate-x-5': toggled }"></div>

        </div>
        <span class="ml-3 text-sm font-medium">Substituce UUID</span>
    </div>
</div>
