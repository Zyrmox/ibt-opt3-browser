<div>
    <x-slot name="header">
        <div class="flex items-center">
            <livewire:atoms.return-navigation-button />
            <h2 class="font-semibold text-2xl">
                {{ $job->opCathegory() }}
            </h2>
            <div class="ml-6 flex items-center">
                @if ($job->isFullOp())
                    <svg class="h-4 w-4 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                    </svg>
                @elseif ($job->isCoop()) 
                    <svg class="h-4 w-4 text-purple-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                    </svg>
                @else
                    <svg class="h-4 w-4 text-indigo-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="currentColor"/>
                    </svg>
                @endif
                <p class="ml-2 font-medium">
                    @if ($substituted)
                        {{ $job->short_id }}
                    @else
                        {{ $job->sId }}
                    @endif
                </p>
            </div>
        </div>
        @if (!$job->isFullOp())
            <p class="uppercase font-semibold">{{ $job->opType() }}</p>
        @endif
    </x-slot>
    
    <div class="container mx-auto">
        <div class="bg-white p-6 shadow-md rounded-md flex flex-col text-sm">
            <div class="flex justify-between items-center">
                <p class="font-semibold">
                    @if ($substituted)
                        {{ $job->short_id }}
                    @else
                        {{ $job->sId }}
                    @endif    
                </p>
            </div>

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

            @if ($job->isFullOp() || $job->isPhaseOp())
                <div class="mt-8">
                    <x-molecules.expandable-card expanded="true" class="bg-theme-300">
                        <x-slot name="title">
                            <h2 class="font-semibold">Zdroje</h2>
                        </x-slot>
            
                        <div class="mt-8">
                            @foreach ($job->resources() as $resource)
                                <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm">
                                    <div class="flex items-center">
                                        <svg class="h-3 w-3 text-pink-600" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                        </svg>

                                        <a href="{{ route('insights.resource', $resource->sId) }}" class="ml-2 font-medium hover:underline flex">
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
                        </div>
                    </x-molecules.expandable-card>
                </div>
            @endif

            @if ($job->isFullOp() && $job->contextChannels()->exists())
                <div class="bg-theme-300 px-4 py-8 mt-8 rounded shadow-md">
                    <h2 class="font-semibold mb-8">Kontextové kanály</h2>
                    <table class="w-full divide-y divide-gray-200 border-theme-600 border">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach($job->contextChannels->first()->getFilteredAttributes() as $key => $val)
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                        {{ $key }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($job->contextChannels as $channel)
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
        </div>

        @if ($job->isFullOp())
            <x-molecules.expandable-card expanded="true" class="bg-white">
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
            </x-molecules.expandable-card>

            <x-molecules.expandable-card expanded="true" class="bg-white">
                <x-slot name="title">
                    <h2 class="font-semibold">Vlastnící výrobní příkaz</h2>
                </x-slot>
    
                <div class="mt-8">
                    @foreach ($job->VPs() as $vp)
                        <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm">
                            <div class="flex items-center">
                                <svg class="h-3 w-3 text-yellow-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                </svg>
                                <a href="{{ route('insights.vp', $vp->sId) }}" class="ml-2 font-medium hover:underline">
                                    @if ($substituted)
                                        {{ $vp->short_id }}
                                    @else
                                        {{ $vp->sId }}
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-molecules.expandable-card>
        @elseif ($job->isPhaseOp())
            <x-molecules.expandable-card expanded="true" class="bg-white">
                <x-slot name="title">
                    <h2 class="font-semibold">Vlastnící plná operace</h2>
                </x-slot>

                <div class="mt-8">
                    <div class="bg-theme-400 px-6 py-4 mb-4 shadow-inner rounded flex justify-between items-center text-sm">
                        <div class="flex items-center">
                            @if ($job->fullOperation()->first()->isFullOp())
                                <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                </svg>
                            @else 
                                <svg class="h-3 w-3 text-theme-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m21 12c0 4.9706-4.0295 9-9 9v-18c4.9705 0 9 4.0294 9 9zm3 0c0 6.6274-5.3726 12-12 12-6.6274 0-12-5.3726-12-12 0-6.6274 5.3726-12 12-12 6.6274 0 12 5.3726 12 12z" clip-rule="evenodd" fill="currentColor" fill-rule="evenodd"/>
                                </svg>
                            @endif
                            <a href="{{ route('insights.job', $job->fullOperation()->first()->sId) }}" class="ml-2 font-medium hover:underline">
                                @if ($substituted)
                                    {{ $job->fullOperation()->first()->short_id }}
                                @else
                                    {{ $job->fullOperation()->first()->sId }}
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </x-molecules.expandable-card>
        @endif
    </div>
</div>