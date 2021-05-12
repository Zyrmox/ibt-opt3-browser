<div>
    <!--
        Materials View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/MaterialsInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl">
            {{ __('Materiály v úloze') }}
        </h2>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">

        <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
            <div class="flex justify-between items-center">
                <form class="flex items-center justify-between w-full">
                    <div class="flex">
                        <div>
                            <label for="view" class="mr-2 font-medium">Zobrazení:</label>
                            <select wire:model="view" name="view" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (MaterialsInsight::$viewsToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        @if ($view == MaterialsInsight::VIEW_MATERIALS_TABLE)
                            <div class="ml-8">
                                <label for="groupByAmount" class="mr-2 font-medium">Řazení:</label>
                                <select wire:model="groupByAmount" name="groupByAmount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                    @foreach (MaterialsInsight::$groupByAmountToggle as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @elseif ($view == MaterialsInsight::VIEW_WAREHOUSES_TABLE)
                            {{-- <div class="ml-8">
                                <label for="groupByMaterialsCount" class="mr-2 font-medium">Řazení:</label>
                                <select wire:model="groupByMaterialsCount" name="groupByMaterialsCount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                    @foreach (MaterialsInsight::$groupByMaterialsCountToggle as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                        @endif
    
                    </div>
                    
                    @if ($this->viewIs(MaterialsInsight::VIEW_MATERIALS_TABLE))
                        <div>
                            <label for="paginationCount" class="mr-2 font-medium">Záznamů na stránku:</label>
                            <select wire:model="paginationCount" name="paginationCount" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        <div class="flex justify-between items-center mb-3">
            @if ($view == MaterialsInsight::VIEW_MATERIALS_TABLE)
                <div class="w-full">{{ $materials->links() }}</div>
            @elseif ($view == MaterialsInsight::VIEW_WAREHOUSES_TABLE)
                <div class="w-full">{{ $warehouses->links() }}</div>
            @endif
        </div>

        @if ($this->viewIs(MaterialsInsight::VIEW_MATERIALS_TABLE))
            @if ($materials->first()->exists())
                <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($materials->first()->getFilteredAttributes() as $key => $val)
                                <th scope="col" class="sticky top-0 px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                    {{ $key }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($materials as $key => $material)
                            <tr>
                                @foreach($material->getFilteredAttributes() as $key => $attr)
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        @if ($key == 'sId') 
                                            <svg class="inline mr-2 h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                            </svg>
                                            
                                            <a href="{{ route('insights.material', $material->sId) }}" title="{{ $material->sId }}" class="ml-2 hover:underline">
                                                @if($substituted)
                                                    {{ $material->short_id }}
                                                @else
                                                    {{ $attr }}
                                                @endif
                                            </a>
                                        @else
                                            {{ $attr == null ? '-' : $attr }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @elseif($this->viewIs(MaterialsInsight::VIEW_WAREHOUSES_TABLE))
            {{-- @if (!$warehouses->isEmpty())
                <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border relative overflow-y-hidden">
                    <tbody class="bg-white divide-y divide-gray-200 relative">
                        @foreach ($warehouses as $key => $warehouse)
                            <table class="w-full divide-y divide-gray-200 relative overflow-y-hidden border-theme-900 border-2 border-b-0">
                                <thead>
                                    <tr>
                                        <th colspan="{{ count($materials->first()->getFilteredAttributes()) }}" class="sticky top-0 px-4 py-3 bg-theme-600">
                                            <div class="flex items-center">
                                                <p class="ml-2 font-semibold">
                                                    Sklad: <span class="font-medium ml-2">{{ $warehouse->whouseID }}</span>
                                                </p>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        @foreach($materials->first()->getFilteredAttributes() as $key => $val)
                                            <th scope="col" class="sticky top-10 px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                                {{ $key }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 relative">
                                    @foreach ($warehouse->materials as $key => $material)
                                        <tr wire:key="{{ $material->sId }}">
                                            @foreach($material->getFilteredAttributes() as $key => $attr)
                                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                                    @if ($key == 'sId') 
                                                        <svg class="inline mr-2 h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                        </svg>
                                                        
                                                        <a href="{{ route('insights.material', $material->sId) }}" title="{{ $material->sId }}" class="ml-2 hover:underline">
                                                            @if($substituted)
                                                                {{ $material->short_id }}
                                                            @else
                                                                {{ $attr }}
                                                            @endif
                                                        </a>
                                                    @else
                                                        {{ $attr }}
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
                    </tbody>
                </table>
            @endif --}}
            @foreach ($warehouses as $key => $warehouse)
                <x-molecules.compressed-expandable-card wire:key="{{ $warehouse->whouseID }}" class="bg-white">
                    <x-slot name="title">
                        <p class="ml-2 font-semibold">
                            Sklad: <span class="font-medium ml-2">{{ $warehouse->whouseID }}</span>
                        </p>
                    </x-slot>
                    <x-slot name="header">
                        @if ((count($warehouse->materials)) > 0)
                            <p class="font-medium">
                                <span class="font-semibold ml-2 text-theme-500">{{ $this->getTotalWarehouseRecordsCount($warehouse->whouseID) }}x</span>&nbsp; uložených materiálů
                            </p>
                        @endif
                    </x-slot>

                    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach(Material::first()->getFilteredAttributes() as $col => $val)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                        {{ $col }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($warehouse->materials as $key => $material)
                                <tr wire:key="{{ $material->sId }}">
                                    @foreach($material->getFilteredAttributes() as $key => $attr)
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            @if ($key == 'sId') 
                                                <svg class="inline mr-2 h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                                </svg>
                                                
                                                <a href="{{ route('insights.material', $material->sId) }}" title="{{ $material->sId }}" class="ml-2 hover:underline">
                                                    @if($substituted)
                                                        {{ $material->short_id }}
                                                    @else
                                                        {{ $attr }}
                                                    @endif
                                                </a>
                                            @else
                                                {{ $attr }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($this->getTotalWarehouseRecordsCount($warehouse->whouseID) > $recordsPerWarehouse->get($warehouse->whouseID))
                        <div class="mt-4 flex flex-col justify-center items-center">
                            <button wire:click="updatePerWarehouseListAmount('{{ $warehouse->whouseID }}')" class="py-3 px-6 font-semibold text-xs uppercase bg-theme-900 text-white">Načíst další záznamy</button>
                            <div class="mt-4">
                                Zobrazeno <span class="font-medium">{{ count($warehouse->materials) }} z {{ $this->getTotalWarehouseRecordsCount($warehouse->whouseID) }} celkových záznamů</span>
                            </div>
                        </div>
                    @endif
                </x-molecules.compressed-expandable-card>
            @endforeach
        @endif

        {{-- @foreach ($materials as $key => $material)
            <x-molecules.expandable-card wire:key="{{ $material->sId }}">
                <x-slot name="title">
                    <svg class="h-3 w-3 text-green-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                    </svg>
                    
                    <a href="{{ route('insights.resource', $material->sId) }}" title="{{ $material->sId }}" class="ml-2 font-medium hover:underline">
                        @if($substituted)
                            {{ $material->short_id }}
                        @else
                            {{ $material->sId }}
                        @endif
                    </a>
                </x-slot>

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
            </x-molecules.expandable-card>
        @endforeach --}}
    </div>
</div>