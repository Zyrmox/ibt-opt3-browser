<div>
    <!--
        Context Channels (CProps) View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/CPropsInsight.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('CProp') }}
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
                            @foreach (CPropsInsight::$typesToggle as $key => $type)
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
            <div class="w-full">{{ $cprops->links() }}</div>
        </div>

        <div class="mt-3">
            {{-- @foreach ($cprops as $key => $cprop)
                <x-molecules.compressed-expandable-card class="bg-white" wire:key="{{ $cprop->Type . $cprop->refID }}">
                    <x-slot name="title">
                        <span class="mr-4 font-medium">refID:</span>
                        <svg class="h-4 w-4 {{ $cprop->reference()->color() }}" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                        </svg>
                        
                        <a href="{{ route('insights.' . strtolower(basename(get_class($cprop->reference()))), $cprop->reference()->sId) }}" title="{{ $cprop->reference()->sId }}" class="ml-2 font-medium hover:underline">
                            @if($substituted)
                                {{ $cprop->reference()->short_id }}
                            @else
                                {{ $cprop->refID }}
                            @endif
                        </a>
                    </x-slot>

                    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach($cprop->getFilteredAttributes() as $key => $val)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                        {{ $key }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                @foreach($cprop->getFilteredAttributes() as $key => $val)
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        {{ $val != null ? $val : '-' }}
                                    </td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </x-molecules.compressed-expandable-card>
            @endforeach --}}
            @if ($cprops->first()->exists())
                <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($cprops->first()->getFilteredAttributes() as $key => $val)
                                <th scope="col" class="sticky top-0 px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                    {{ $key }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($cprops as $key => $cprop)
                            <tr wire:key="{{ $cprop->Type . $cprop->refID }}">
                                @foreach($cprop->getFilteredAttributes() as $key => $attr)
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        @if ($key == 'refID') 
                                            <svg class="inline mr-2 h-4 w-4 {{ $cprop->reference()->color() }}" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                            </svg>
                                            
                                            <a href="{{ route('insights.' . strtolower(class_basename(get_class($cprop->reference()))), $cprop->reference()->sId) }}" title="{{ $cprop->reference()->sId }}" class="font-medium hover:underline">
                                                @if($substituted)
                                                    {{ $cprop->reference()->short_id }}
                                                @else
                                                    {{ $cprop->refID }}
                                                @endif
                                            </a>
                                        @else
                                            {{ $attr != null ? $attr : '-' }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>