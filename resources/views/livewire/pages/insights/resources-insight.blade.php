<div>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Zdroje v úloze') }}
        </h2>
    </x-slot>

    <x-molecules.loading-state-notification />
    
    <div class="pb-8 pt-0">
        <div class="container mx-auto">

            <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
                <form class="flex items-center justify-between w-full">
                    <div class="flex">
                        <div>
                            <label for="paginationCount" class="mr-2 font-medium">Zobrazit:</label>
                            <select wire:model="filterByType" name="filterByType" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (ResourcesInsight::$typesToggle as $key => $type)
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
                <div class="w-full">{{ $resources->links() }}</div>
            </div>

            <div class="mt-3">
                @if (count($resources) > 0)
                    @foreach ($resources as $key => $resource)
                        <x-molecules.compressed-expandable-card class="bg-white" wire:key="{{ $resource->sId }}">
                            <x-slot name="title">
                                <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                </svg>
                                
                                <a href="{{ route('insights.resource', $resource->sId) }}" title="{{ $resource->sId }}" class="ml-2 font-medium hover:underline">
                                    @if($substituted)
                                        {{ $resource->short_id }}
                                    @else
                                        {{ $resource->sId }}
                                    @endif
                                </a>
                            </x-slot>
        
                            <x-slot name="header">
                                <span class=" leading-5 font-semibold uppercase text-pink-600 text-xs">
                                    {{ $resource->type() }}
                                </span>
                            </x-slot>
        
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
                        </x-molecules.compressed-expandable-card>
                    @endforeach
                @endif

                {{-- @if (count($resources) > 0)
                    <div class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
                        <div class="flex bg-gray-50 w-full">
                            <div class=" px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                {{ Resource::primaryKey() }}
                            </div>
                            @foreach($resources->first()->getFilteredAttributes(false) as $key => $val)
                                <div class="w-1/6 px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                    {{ $key }}
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-white divide-y divide-gray-200 w-full">
                            @foreach ($resources as $key => $resource)
                                <div class="flex w-full" wire:key="{{ $resource->sId }}" x-data="{ expanded: true }">
                                    <div class="w-1/6 max-w-1/6 px-6 py-4 whitespace-nowrap font-medium flex items-center">
                                        <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                        </svg>
                                        
                                        <a href="{{ route('insights.resource', $resource->sId) }}" title="{{ $resource->sId }}" class="ml-4 font-medium hover:underline">
                                            @if($substituted)
                                                {{ $resource->short_id }}
                                            @else
                                                {{ $resource->sId }}
                                            @endif
                                        </a>
                                    </div>
                                    @foreach($resource->getFilteredAttributes(false) as $key => $val)
                                        <div class="w-1/6 px-6 py-4 whitespace-nowrap font-medium">
                                            {{ $val != null ? $val : '-' }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif --}}
            </div>
        </div>
    </div>
</div>