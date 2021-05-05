<div>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Deadlines (VP)') }}
        </h2>
    </x-slot>
    
    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">

        <div class="flex mb-8 space-x-4">
            <div class="px-8 py-4 bg-white rounded w-full flex items-center border-2 border-yellow-500">
                <span class="mr-4 p-3 bg-yellow-100 text-yellow-500 rounded-md">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <span class="flex flex-col">
                    <span class="text-lg">
                        <span class="mr-1 font-semibold">{{ count(VP::missedDeadlines()->get()) }}</span>
                        Deadlinů plánovaných do minulosti
                        <span class="ml-2">
                            (<span class="font-semibold">{{ count(VP::withMissedDeadlines()->get()) }}</span> VP)
                        </span>
                    </span>
                </span>
            </div>
            <div class="px-8 py-4 bg-white rounded w-full flex items-center border-2 border-green-500">
                <span class="mr-4 p-3 bg-green-100 text-green-500 rounded-md">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </span>
                <span class="text-lg">
                    <span class="mr-1 font-semibold">{{ count(VP::futureDeadlines()->get()) }}</span>
                        Deadlinů plánovaných do budoucnosti
                    <span class="ml-2">
                        (<span class="font-semibold">{{ count(VP::withFutureDeadlines()->get()) }}</span> VP)
                    </span>
                </span>
            </div>
        </div>

        <div  class="mb-16">
            <h2 class="mb-3 text-lg font-semibold">Časová osa</h2>

            <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
                <form class="flex justify-between items-center w-full">
                    <div class="flex">
                        <div>
                            <label for="filterByType" class="mr-2 font-medium">Zobrazit:</label>
                            <select wire:model="filterByType" name="filterByType" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (VPDeadlinesInsight::$typesToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-8">
                            <label for="sortByDate" class="mr-2 font-medium">Řazení:</label>
                            <select wire:model="sortByDate" name="sortByDate" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (VPDeadlinesInsight::$dateSortingToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="ml-8">
                        <label for="paginationCount" class="mr-2 font-medium">Záznamů na stránku:</label>
                        <select wire:model="paginationCount" name="paginationCount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="flex justify-between items-center mb-3">
                <div class="w-full">{{ $deadlines->links() }}</div>
            </div>

            <div class="max-w-full w-full overflow-x-auto flex flex-col items-start pb-6">
                @foreach ($deadlines as $deadline)
                    <div class="p-3 mb-4 bg-white shadow-md flex-shrink-0 w-full">
                        <div class="flex justify-between flex-wrap items-center">
                            <div class="flex">
                                <span class="mr-2 p-1 bg-yellow-100 text-yellow-500 rounded-md">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </span>
                                <p class="font-medium sticky">
                                    {{ dateFromDateTime($deadline->deadline) }}
                                </p>
                            </div>
                            @if ($deadline->isDeadlinePastDue())
                                <span class="py-1 px-4 text-xs font-medium bg-yellow-100 rounded-full text-yellow-600 flex items-center border shadow-inner">
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Termín v minulosti
                                </span>
                            @endif
                        </div>
                        <div class="mt-3">
                            <x-molecules.compressed-expandable-card wire:key="{{ $deadline->deadline }}" class="bg-theme-300 shadow-inner">
                                <x-slot name="title">
                                    <p>
                                        Počet výrobních příkazů:
                                        <span class="font-medium ml-2">{{ count(VP::whereDeadline($deadline->deadline)->get()) }}x</span>
                                    </p>
                                </x-slot>

                                <div>
                                    @foreach (VP::whereDeadline($deadline->deadline)->get() as $key => $vp)
                                        <x-molecules.compressed-expandable-card wire:key="{{ $vp->sId }}" class="bg-white shadow-inner">
                                            <x-slot name="title">
                                                <svg class="h-3 w-3 text-yellow-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                </svg>
                                                
                                                <a href="{{ route('insights.vp', $vp->sId) }}" title="{{ $vp->sId }}" class="ml-2 font-medium hover:underline">
                                                    @if($substituted)
                                                        {{ $vp->short_id }}
                                                    @else
                                                        {{ $vp->sId }}
                                                    @endif
                                                </a>
                                            </x-slot>
                            
                                            <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        @foreach($vp->getFilteredAttributes() as $key => $val)
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                                                {{ $key }}
                                                            </th>
                                                        @endforeach
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    <tr>
                                                    @foreach($vp->getFilteredAttributes() as $key => $val)
                                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                                            {{ $val != null ? $val : '-' }}
                                                        </td>
                                                    @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </x-molecules.compressed-expandable-card>
                                    @endforeach
                                </div>
                            </x-molecules.compressed-expandable-card>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="px-4 py-3 bg-white rounded">
            <h2 class="mb-3 text-lg font-semibold">Kalendář</h2>
            <div class="mt-6" id='calendar' wire:ignore></div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ mix('css/fullcalendar.css') }}">
    @endpush
    @prepend('scripts')
        <script src="{{ mix('js/fullcalendar.js') }}"></script>
        <script src="{{ mix('js/fullcalendar-cs.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
              var calendarEl = document.getElementById('calendar');
              var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'cs',
                initialView: 'dayGridMonth',
                events: '/json/deadlines',
              });
              calendar.render();
            });
        </script>
    @endprepend
</div>