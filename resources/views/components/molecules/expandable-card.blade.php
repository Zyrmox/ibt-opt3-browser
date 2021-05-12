<div {{ $attributes->merge(['class' => 'p-4 shadow-md rounded flex flex-col my-3 text-sm overflow-auto relative']) }} x-data="{ expanded: {{ $expanded ? 'true' : 'false'}} }">
    <!--
        Expandable Card - Laravel Component
        Controller for this component: App/View/Components/Molecules/ExpandableCard.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            @if (!$disabled)
                <button class="px-2 py-2 bg-gray-600 bg-opacity-0 hover:bg-opacity-5 rounded-full mr-4 focus:outline-none" @click="expanded = !expanded">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-cloak x-show="!expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        <path x-cloak x-show="expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                    </svg>
                </button>
            @endif
            
            {{ $title }}

        </div>
        {{ isset($header) ? $header : '' }}
    </div>
    <div x-show="expanded" x-cloak class="min-w-full overflow-x-auto">
        {{ $slot }}
    </div>
</div>