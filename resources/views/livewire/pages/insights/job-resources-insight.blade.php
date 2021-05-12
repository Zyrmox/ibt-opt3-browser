<div>
    <!--
        Job Resources View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/JobResourcesInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Požadavky operací na zdroje') }}
        </h2>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="pb-8 pt-0">
        <div class="container mx-auto">
            <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
                <form class="flex items-center justify-end w-full">
                    <label for="paginationCount" class="mr-2 font-medium">Záznamů na stránku:</label>
                    <select wire:model="paginationCount" name="paginationCount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </form>
            </div>

            <div class="flex justify-between items-center">
                <div class="w-full">{{ $fullJobs->links() }}</div>
            </div>

            <div class="mt-3">
                @foreach ($fullJobs as $key => $job)
                    <x-molecules.compressed-expandable-card class="bg-white" wire:key="{{ $job->sId }}">
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
</div>