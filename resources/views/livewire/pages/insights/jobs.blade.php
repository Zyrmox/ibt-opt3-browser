<div>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Výrobní operace') }}
        </h2>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">
        <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
            <form class="flex items-center justify-between w-full">
                <div class="flex">
                    <div>
                        <label for="filterByType" class="mr-2 font-medium">Zobrazit:</label>
                        <select wire:model="filterByType" name="filterByType" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                            @foreach (Jobs::$typesToggle as $key => $type)
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

        <div class="flex justify-between items-center">
            <div class="w-full">{{ $operations->links() }}</div>
        </div>

        <div class="mt-3">
            @forelse ($operations as $key => $job)
                <x-molecules.compressed-expandable-card class="bg-white" wire:key="{{ $job->sId }}">
                    <x-slot name="title">
                        @if ($job->isFullOp())
                            <svg class="h-4 w-4 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                            </svg>
                        @elseif ($job->isCoop()) 
                            <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                            </svg>
                        @endif
                        
                        <a href="{{ route('insights.job', $job->sId) }}" title="{{ $job->sId }}" class="ml-2 font-medium hover:underline">
                            @if($substituted)
                                {{ $job->short_id }}
                            @else
                                {{ $job->sId }}
                            @endif
                        </a>
                    </x-slot>

                    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach($job->getFilteredAttributes() as $key => $val)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                        {{ $key }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                            @foreach($job->getFilteredAttributes() as $key => $val)
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    {{ $val != null ? $val : '-' }}
                                </td>
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-6">
                        @foreach ($job->phaseOperations() as $key => $op)
                            <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm w-full" wire:key="{{ $op->sId }}">
                                <div class="flex items-center">
                                    <svg class="h-3 w-3 text-indigo-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                    </svg>

                                    <a href="{{ route('insights.job', $op->sId) }}" title="{{ $op->sId }}" class="ml-2 font-medium hover:underline">
                                        @if($substituted)
                                            {{ $op->short_id }}
                                        @else
                                            {{ $op->sId }}
                                        @endif
                                    </a>
                                </div>
                                <span>
                                    <span class="ml-2 leading-5 font-semibold uppercase text-indigo-500 text-xs">
                                        {{ $op->opTypeShort() }}
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </x-molecules.compressed-expandable-card>
            @empty

            <div class="p-3">
                <span>Nenalezeny žádné záznamy<span>
            </div>

            @endforelse
        </div>
    </div>
</div>