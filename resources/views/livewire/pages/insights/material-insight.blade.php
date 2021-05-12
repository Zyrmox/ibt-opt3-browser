<div>
    <!--
        Specific Material View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/MaterialInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <div class="flex items-center">
            <livewire:molecules.return-navigation-button />
            <h2 class="font-semibold text-2xl">
                Materiál
            </h2>
            <div class="ml-6 flex items-center">
                <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                </svg>
                <p class="ml-2 font-medium">
                    @if ($substituted)
                        {{ $material->short_id }}
                    @else
                        {{ $material->sId }}
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">
        <div class="bg-white p-6 shadow-md rounded-md flex flex-col text-sm">
            <div class="flex justify-between items-center">
                <p class="font-semibold">
                    @if ($substituted)
                        {{ $material->short_id }}
                    @else
                        {{ $material->sId }}
                    @endif    
                </p>
            </div>

            <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($material->getFilteredAttributes() as $key => $val)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                {{ $key }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>
                    @foreach($material->getFilteredAttributes() as $key => $val)
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            {{ $val != null ? $val : '-' }}
                        </td>
                    @endforeach
                  </tr>
                </tbody>
            </table>

            <x-molecules.expandable-card expanded="true" class="bg-theme-300 mt-8">
                <x-slot name="title">
                    <span class="font-semibold">Události</span>
                </x-slot>

                <div class="">
                    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <thead class="bg-theme-400">
                            <tr>
                                @foreach($material->matEvents->first()->getFilteredAttributes() as $key => $val)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                        {{ $key }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($material->matEvents as $event)
                                <tr>
                                    @foreach($event->getFilteredAttributes() as $key => $val)
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            <div class="flex items-center">
                                                @if ($key == 'jobId' && $val != null)
                                                    @if ($event->job->isFullOp())
                                                        <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                        </svg>
                                                    @elseif($event->job->isCoop())
                                                        <svg class="h-3 w-3 text-purple-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                        </svg>
                                                    @endif
                                                    <a href="{{ route('insights.job', $event->job->sId) }}" title="{{ $event->job->sId }}" class="ml-2 font-medium hover:underline">
                                                        @if($substituted)
                                                            {{ $event->job->short_id }}
                                                        @else
                                                            {{ $event->job->sId }}
                                                        @endif
                                                    </a>
                                                @else
                                                    {{ $val != null ? $val : '-' }}
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-molecules.expandable-card>
        </div>

        {{-- <x-molecules.expandable-card expanded="true" class="bg-white">
            <x-slot name="title">
                <h2 class="font-semibold">Fázové operace</h2>
            </x-slot>
            
            <ul class="mt-8">
                @foreach ($job->phaseOperations() as $key => $op)
                    <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm" wire:key="{{ $op->sId }}">
                        <div class="flex items-center">
                            @if ($op->isFullOp())
                                <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                </svg>
                            @else 
                                <svg class="h-3 w-3 text-indigo-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                </svg>
                            @endif
                            <a href="{{ route('insights.job', $op->sId) }}" class="ml-2 font-medium hover:underline">
                                @if ($substituted)
                                    {{ $op->short_id }}
                                @else
                                    {{ $op->sId }}
                                @endif
                            </a>
                        </div>
                        <span class=" leading-5 font-semibold uppercase text-indigo-500 text-xs">
                            {{ $op->opType() }}
                        </span>
                    </div>
                @endforeach
            </ul>
            <x-molecules.expandable-card class="bg-theme-300">
                <x-slot name="title">
                    <h2 class="font-semibold">Požadavky fázových operací na zdroje</h2>
                </x-slot>
    
                <div class="mt-8">
                    @foreach ($job->phaseOperations() as $key => $op)
                        @foreach ($op->resources() as $resource)
                            <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm" wire:key="{{ $op->sId }}">
                                <div class="flex items-center">
                                    <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                    </svg>
                                    <a href="{{ route('insights.resource', $resource->sId) }}" class="ml-2 font-medium hover:underline">
                                        @if ($substituted)
                                            {{ $resource->short_id }}
                                        @else
                                            {{ $resource->sId }}
                                        @endif
                                    </a>
                                </div>
                                <span class=" leading-5 font-semibold uppercase text-pink-600 text-xs">
                                    {{ $resource->type() }}
                                </span>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </x-molecules.expandable-card>
        </x-molecules.expandable-card> --}}
    </div>
</div>