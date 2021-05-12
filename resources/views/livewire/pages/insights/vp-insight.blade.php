<div>
    <!--
        Specific Manufacturing Order (česky VP) View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/VPInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <div class="flex items-center">
            <livewire:molecules.return-navigation-button />
            <h2 class="font-semibold text-2xl">
                Výrobní příkaz
            </h2>
            <div class="ml-6 flex items-center">
                <svg class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                </svg>
                <p class="ml-2 font-medium">
                    @if ($substituted)
                        {{ $vp->short_id }}
                    @else
                        {{ $vp->sId }}
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto">
        <div class="bg-white p-6 shadow-md rounded-md flex flex-col text-sm">
            <div class="flex justify-between items-center">
                <p class="font-semibold">
                    @if ($substituted)
                        {{ $vp->short_id }}
                    @else
                        {{ $vp->sId }}
                    @endif
                </p>
            </div>

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

        </div>

        @if (count($vp->relFullOperations()) > 0)
            <x-molecules.expandable-card expanded="true" class="bg-white">
                <x-slot name="title">
                    <h2 class="font-semibold">Operace</h2>
                </x-slot>

                <ul class="mt-8">
                    @foreach ($vp->relFullOperations() as $key => $op)
                        <x-molecules.expandable-card class="bg-theme-300">
                            <x-slot name="title">
                                <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

                            <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach($op->getFilteredAttributes() as $key => $val)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                                {{ $key }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                    @foreach($op->getFilteredAttributes() as $key => $val)
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            {{ $val != null ? $val : '-' }}
                                        </td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                
                            <ul class="mt-8">
                                @foreach ($op->phaseOperations() as $key => $phase)
                                    <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm" wire:key="{{ $phase->sId }}">
                                        <div class="flex items-center">
                                            <svg class="h-3 w-3 text-indigo-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                            </svg>
                                            <a href="{{ route('insights.job', $phase->sId) }}" class="ml-2 font-medium hover:underline">
                                                @if ($substituted)
                                                    {{ $phase->short_id }}
                                                @else
                                                    {{ $phase->sId }}
                                                @endif
                                            </a>
                                        </div>
                                        <span class=" leading-5 font-semibold uppercase text-indigo-500 text-xs">
                                            {{ $phase->opType() }}
                                        </span>
                                    </div>
                                @endforeach
                            </ul>
                        </x-molecules.expandable-card>
                    @endforeach
                </ul>
            </x-molecules.expandable-card>
        @endif

        @if (count($vp->relCooperations()) > 0)
            <x-molecules.expandable-card expanded="true" class="bg-white">
                <x-slot name="title">
                    <h2 class="font-semibold">Kooperace</h2>
                </x-slot>

                <ul class="mt-8">
                    @foreach ($vp->relCooperations() as $key => $op)
                        <x-molecules.expandable-card class="bg-theme-300">
                            <x-slot name="title">
                                <svg class="h-3 w-3 text-purple-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

                            <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach($op->getFilteredAttributes() as $key => $val)
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                                {{ $key }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    @foreach($op->getFilteredAttributes() as $key => $val)
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            {{ $val != null ? $val : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>
                            </table>

                            @if (count($op->phaseOperations()) > 0)
                                <ul class="mt-8">
                                    @foreach ($op->phaseOperations() as $key => $phase)
                                        <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm" wire:key="{{ $phase->sId }}">
                                            <div class="flex items-center">
                                                <svg class="h-3 w-3 text-indigo-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                </svg>
                                                <a href="{{ route('insights.job', $phase->sId) }}" class="ml-2 font-medium hover:underline">
                                                    @if ($substituted)
                                                        {{ $phase->short_id }}
                                                    @else
                                                        {{ $phase->sId }}
                                                    @endif
                                                </a>
                                            </div>
                                            <span class=" leading-5 font-semibold uppercase text-indigo-500 text-xs">
                                                {{ $phase->opType() }}
                                            </span>
                                        </div>
                                    @endforeach
                                </ul>
                            @endif
                        </x-molecules.expandable-card>
                    @endforeach
                </ul>
            </x-molecules.expandable-card>
        @endif

        <x-molecules.expandable-card expanded="true" class="bg-white">
            <x-slot name="title">
                <h2 class="font-semibold">Zdroje využívané operacemi</h2>
            </x-slot>

            <ul class="mt-8">
                @foreach ($vp->resources() as $key => $resource)
                    <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm" wire:key="{{ $resource->sId }}">
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
            </ul>
        </x-molecules.expandable-card>
    </div>
</div>