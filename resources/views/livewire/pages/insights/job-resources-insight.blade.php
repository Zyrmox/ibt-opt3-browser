<div>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Zdroje v úloze') }}
        </h2>
    </x-slot>
    
    <div class="py-8">
        <div class="container mx-auto">
            <div class="flex justify-between items-center">
                <form class="flex items-center justify-end">
                    <label for="paginationCount" class="mr-2 font-medium">Záznamů na stránku:</label>
                    <select wire:model="paginationCount" name="paginationCount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </form>
                <div>{{ $fullJobs->links() }}</div>
            </div>

            @foreach ($fullJobs as $key => $job)
                <x-molecules.expandable-card class="bg-white" wire:key="{{ $job->sId }}">
                    <x-slot name="title">
                        <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                        </svg>
                        
                        <a href="{{ route('insights.resource', $job->sId) }}" title="{{ $job->sId }}" class="ml-2 font-medium hover:underline">
                            @if($substituted)
                                {{ $job->short_id }}
                            @else
                                {{ $job->sId }}
                            @endif
                        </a>
                    </x-slot>

                    <div class="mt-6">
                        @foreach ($job->resources() as $key => $res)
                            <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm w-full" wire:key="{{ $res->sId }}">
                                <div class="flex items-center">
                                    <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                    </svg>
    
                                    <a href="{{ route('insights.resource', $res->sId) }}" title="{{ $res->sId }}" class="ml-2 font-medium hover:underline">
                                        @if($substituted)
                                            {{ $res->short_id }}
                                        @else
                                            {{ $res->sId }}
                                        @endif
                                    </a>
                                </div>
                                <span>
                                    <span class="ml-2 leading-5 font-semibold uppercase text-pink-600 text-xs">
                                        {{ $res->type() }}
                                    </span>
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        @foreach ($job->phaseOperations() as $key => $op)
                            <x-molecules.expandable-card class="bg-theme-300" wire:key="{{ $op->sId }}" bgColor="bg-theme-300" expanded="true">
                                <x-slot name="title">
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
                                </x-slot>

                                <x-slot name="header">
                                    <span>
                                        <span class="ml-2 leading-5 font-semibold uppercase text-indigo-600 text-xs">
                                            {{ $op->opType() }}
                                        </span>
                                    </span>
                                </x-slot>

                                <div class="mt-6">
                                    @foreach ($op->resources() as $key => $res)
                                        <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm w-full" wire:key="{{ $res->sId }}">
                                            <div class="flex items-center">
                                                <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                </svg>

                                                <a href="{{ route('insights.resource', $res->sId) }}" title="{{ $res->sId }}" class="ml-2 font-medium hover:underline">
                                                    @if($substituted)
                                                        {{ $res->short_id }}
                                                    @else
                                                        {{ $res->sId }}
                                                    @endif
                                                </a>
                                            </div>
                                            <span>
                                                <span class="ml-2 leading-5 font-semibold uppercase text-pink-600 text-xs">
                                                    {{ $res->type() }}
                                                </span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </x-molecules.expandable-card>
                        @endforeach
                    </div>
                </x-molecules.expandable-card>
            @endforeach
        </div>
    </div>
</div>