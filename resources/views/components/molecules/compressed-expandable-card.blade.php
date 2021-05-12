<div {{ $attributes->merge(['class' => 'shadow-md flex flex-col border border-theme-600 text-sm overflow-auto z-10 relative']) }} x-data="{ expanded: {{ $expanded ? 'true' : 'false'}} }">
    <!--
        Compressed (small) Expandable Card - Laravel Component
        Controller for this component: App/View/Components/Molecules/CompressedExpandableCard.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <div class="flex items-center justify-between px-4 py-3">
        <div class="flex items-center">
            <button class="px-2 py-2 bg-gray-600 bg-opacity-0 hover:bg-opacity-5 rounded-full mr-4 focus:outline-none" @click="expanded = !expanded">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-cloak x-show="!expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    <path x-cloak x-show="expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                </svg>
            </button>
            {{ $title }}

        </div>
        {{ isset($header) ? $header : '' }}
    </div>
    <div x-show="expanded" x-cloak class="min-w-full overflow-x-auto bg-gray-100 @if (!$disablePaddingX) px-4 @endif pb-3">
        {{ $slot }}
    </div>
</div>