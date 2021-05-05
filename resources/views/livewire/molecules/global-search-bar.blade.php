<div class="w-1/2 relative" x-data="{ filters: @entangle('filters'), toggle: @entangle('toggleAll'), showResults: @entangle('showResults'), searching: false, progress: 0 }">
    <ul class="list-none mb-2 flex">
        <li class="mr-1">
            <button wire:click="toggleAllFilters()" class="px-2 py-1 bg-theme-900 text-white border-2 border-theme-900 hover:bg-white hover:text-theme-900 transition-colors font-medium text-xs uppercase rounded relative flex items-center">
                <span x-show="!toggle">Vybrat vše</span>
                <span x-show="toggle">Odebrat vše</span>
            </button>
        </li>
        <li class="mr-1">
            <button wire:click="toggleFilter('vp')" x-bind:class="{ 'border-green-500': filters['vp'], 'border-theme-600': !filters['vp'] }" class="px-2 py-1 bg-white border-2 hover:bg-theme-300 focus:outline-none font-medium text-xs uppercase rounded relative flex items-center">
                <svg x-show="filters['vp']" x-cloak class="mr-1 w-3 h-3 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                VP
            </button>
        </li>
        <li class="mr-1">
            <button wire:click="toggleFilter('operace')" x-bind:class="{ 'border-green-500': filters['operace'], 'border-theme-600': !filters['operace'] }" class="px-2 py-1 bg-white border-2 hover:bg-theme-300 focus:outline-none font-medium text-xs uppercase rounded relative flex items-center">
                <svg x-show="filters['operace']" x-cloak class="mr-1 w-3 h-3 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Operace
            </button>
        </li>
        <li class="mr-1">
            <button wire:click="toggleFilter('kooperace')" x-bind:class="{ 'border-green-500': filters['kooperace'], 'border-theme-600': !filters['kooperace'] }" class="px-2 py-1 bg-white border-2 hover:bg-theme-300 focus:outline-none font-medium text-xs uppercase rounded relative flex items-center">
                <svg x-show="filters['kooperace']" x-cloak class="mr-1 w-3 h-3 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Kooperace
            </button>
        </li>
        <li class="mr-1">
            <button wire:click="toggleFilter('zdroje')" x-bind:class="{ 'border-green-500': filters['zdroje'], 'border-theme-600': !filters['zdroje'] }" class="px-2 py-1 bg-white border-2 hover:bg-theme-300 focus:outline-none font-medium text-xs uppercase rounded relative flex items-center">
                <svg x-show="filters['zdroje']" x-cloak class="mr-1 w-3 h-3 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Zdroje
            </button>
        </li>
        <li class="mr-1">
            <button wire:click="toggleFilter('materiály')" x-bind:class="{ 'border-green-500': filters['materiály'], 'border-theme-600': !filters['materiály'] }" class="px-2 py-1 bg-white border-2 hover:bg-theme-300 focus:outline-none font-medium text-xs uppercase rounded relative flex items-center">
                <svg x-show="filters['materiály']" x-cloak class="mr-1 w-3 h-3 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                Materiály
            </button>
        </li>
    </ul>
    <form wire:submit.prevent="search" class="relative flex items-center">
        {{-- <!-- Progress Bar -->
        <div class="absolute top-full left-0 w-full">
            <div class="overflow-hidden h-1 mb-4 text-xs flex bg-theme-600">
                <div :style="`width: ${progress}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
            </div>
        </div> --}}

        <input wire:model.defer="search" x-on:focus="showResults = true" type="text" class="w-full border-1 border-theme-400 bg-white h-12 px-5 pr-12 rounded text-sm focus:outline-none relative" placeholder="Hledat">
        <button type="submit" class="absolute flex items-center justify-center right-4 w-10 h-10 focus:outline-none hover:bg-theme-400 rounded-full">
            <svg wire:loading.remove wire:target="search" class="text-gray-600 h-full w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <div wire:loading wire:target="search" class="lds-facebook"><div></div><div></div><div></div></div>
        </button>
    </form>

    {{-- <div x-show.transition.opacity="showResults" x-cloak class="z-50 h-1/2-screen fixed right-0 left-1/3 bottom-0 overflow-hidden">
        <div class="min-h-full absolute inset-0 bottom-0 overflow-hidden">
            <section class="h-full flex" aria-labelledby="slide-over-heading">
                <!--
                  Slide-over panel, show/hide based on slide-over state.
          
                  Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                    From: "translate-x-full"
                    To: "translate-x-0"
                  Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                    From: "translate-x-0"
                    To: "translate-x-full"
                -->
                <div class="relative w-screen">
                    <div class="h-full flex flex-col pt-6 pb-12 bg-white shadow-2xl overflow-y-auto border-t-2 border-theme-600">
                        <div class="w-full px-12">
                            <div class="flex justify-between">
                                <h2 class="text-lg font-semibold">
                                    Výsledek vyhledání: <span class="ml-2 text-theme-500">"{{ $query }}"</span>
                                </h2>
            
                                <button x-on:click="showResults = false" class="p-2 rounded-full bg-theme-900 bg-opacity-0 text-theme-900 hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                                    <span class="sr-only">Close panel</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="mt-6 relative flex-1">
                                <div class="divide-y-4 divide-theme-600">
                                    @forelse($results as $key => $groupResults)
                                        @if (count($groupResults) > 0)
                                            <div class="px-4 py-6 bg-theme-300">
                                                <p class="text-xs font-semibold uppercase mb-4">{{ $key }} ({{ count($groupResults) }})</p>
                                                <ul>
                                                    @foreach ($groupResults as $result)
                                                        <li class="flex items-center">
                                                            <svg class="h-2 w-2 text-{{ $colors[$key] }} inline" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                            </svg>
                                                            <a href="{{ $result["url"] }}" class="hover:underline font-medium">
                                                                <span class="ml-2">{{ $result["sId"] }}</span>
                                                                <span class="ml-2 text-gray-400">[{{ $result["short_id"] }}]</span>
                                                            </a>
                                                        </li>
                                                        <li></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @empty
                                        Výsledky...
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div> --}}
    <div x-show.transition.opacity="showResults" x-cloak class="absolute top-full left-0 w-full z-20">
        <div class="bg-white rounded-b shadow-md p-6 border-theme-900 border-2">
            <div class="w-full">
                <div class="flex justify-between items-center">
                    @if (!empty($results))
                        <h2 class="text-lg font-semibold">
                            Výsledek hledání: <span class="ml-2 text-theme-500">{{ sprintf('"%s"', $query) }}</span>
                        </h2>
                        <button x-on:click="showResults = false" class="p-2 rounded-full bg-theme-900 bg-opacity-0 text-theme-900 hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="sr-only">Close panel</span>
                            <!-- Heroicon name: outline/x -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>

                <div class="mt-2 relative flex-1 overflow-y-auto max-h-1/2-screen">
                    <div class="divide-y-4 divide-theme-600">
                        @forelse($results as $key => $groupResults)
                            @if (count($groupResults) > 0)
                                <div class="px-4 pb-8 bg-theme-300">
                                    <p class="text-xs font-semibold uppercase mb-4 py-4 bg-theme-300 sticky top-0">{{ $key }} ({{ count($groupResults) }})</p>
                                    <ul>
                                        @foreach ($groupResults as $result)
                                            <li class="flex items-center">
                                                <svg class="h-2 w-2 text-{{ $colors[$key] }} inline" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                </svg>
                                                <a href="{{ $result["url"] }}" class="hover:underline font-medium">
                                                    <span class="ml-2">{{ $result["sId"] }}</span>
                                                    <span class="ml-2 text-gray-400">[{{ $result["short_id"] }}]</span>
                                                </a>
                                            </li>
                                            <li></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @empty
                            Načítání předchozích výsledků...
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
