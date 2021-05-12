<div>
    <!--
        Specific Resource View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/ResourceInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <div class="flex items-center">
            <livewire:molecules.return-navigation-button />
            <h2 class="font-semibold text-2xl">
                Zdroj
            </h2>
            <div class="ml-6 flex items-center">
                <svg class="h-4 w-4 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                </svg>
                <p class="ml-2 font-medium">
                    {{ $resource->sId }}
                </p>
            </div>
        </div>
        <p class="uppercase font-semibold">{{ $resource->type() }}</p>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">
        <div class="bg-white p-6 shadow-md rounded-md flex flex-col text-sm">
            <div class="flex justify-between items-center">
                <p class="font-semibold">
                    @if ($substituted)
                        {{ $resource->short_id }}
                    @else
                        {{ $resource->sId }}
                    @endif    
                </p>
            </div>
            
            <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($resource->getFilteredAttributes() as $key => $val)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                {{ $key }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr>
                    @foreach($resource->getFilteredAttributes() as $key => $val)
                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                            {{ $val != null ? $val : '-' }}
                        </td>
                    @endforeach
                  </tr>
                </tbody>
            </table>
        </div>

        @if ($resource->contextChannels()->exists())
            <div class="bg-white px-4 py-8 mt-8 rounded shadow-md">
                <h2 class="font-semibold mb-8">Kontextové kanály</h2>
                <table class="w-full divide-y divide-gray-200 border-theme-600 border">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($resource->contextChannels->first()->getFilteredAttributes() as $key => $val)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                    {{ $key }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($resource->contextChannels as $channel)
                            <tr>
                                @foreach($channel->getFilteredAttributes() as $key => $val)
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        <div class="flex items-center">
                                            {{ $val != null ? $val : '-' }}
                                        </div>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        
        
        <x-molecules.expandable-card class="bg-white">
            <x-slot name="title">
                <h2 class="font-semibold">Kalendář dostupnosti zdrojů</h2>
            </x-slot>
            
            <div class="mt-8">
                <div class="flex justify-between items-center">
                    <input type="text" wire:model.debounce.500ms="search" class="rounded-md bg-theme-300 border-transparent shadow-inner" placeholder="Hledat datum">

                    <div>
                        <label for="paginationCount" class="mr-2 font-medium">Počet záznamů na stránku:</label>
                        <select wire:model="paginationCount" name="paginationCount" class="rounded-md focus:outline-none bg-theme-300 border-none shadow-inner">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                            <option>500</option>
                            <option>1000</option>
                        </select>
                    </div>
                </div>

                <div class="my-6">
                    {!! $calendarRecords->links() !!}
                </div>

                @if (count($calendarRecords) > 0)
                    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach($calendarRecords->first()->getFilteredAttributes() as $key => $val)
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">{{ $key }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($calendarRecords as $key => $record)
                                <tr>
                                    @foreach($record->getFilteredAttributes() as $k => $attr)
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">
                                            {{ $attr }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </x-molecules.expandable-card>
    </div>
</div>