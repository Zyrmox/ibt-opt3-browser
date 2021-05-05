<div>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('Výrobní příkazy') }}
        </h2>
    </x-slot>
    
    
    <x-molecules.loading-state-notification />
    
    <div class="container mx-auto">
        <div class="bg-theme-600 px-8 py-4 mb-8 text-sm">
            <form class="flex items-center justify-between w-full">
                <div class="flex">
                    <div>
                        <label for="view" class="mr-2 font-medium">Zobrazení:</label>
                        <select wire:model="view" name="view" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                            @foreach (VPsInsight::$viewsToggle as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($view == VPsInsight::VIEW_VPS_TABLE)
                        <div class="ml-8">
                            <label for="filterByType" class="mr-2 font-medium">Podle obsahu:</label>
                            <select wire:model="filterByType" name="filterByType" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (VPsInsight::$typesToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($view == VPsInsight::VIEW_VPS_GROUPED_BY_PRIORITY)
                        <div class="ml-8">
                            <label for="groupByPriority" class="mr-2 font-medium">Řazení:</label>
                            <select wire:model="groupByPriority" name="groupByPriority" class="rounded-md focus:outline-none bg-white border-none shadow-inner">
                                @foreach (VPsInsight::$groupByPriorityToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ml-8 flex items-start">
                            <div class="flex items-center h-6">
                              <input wire:model="disableNonPriority" name="disableNonPriority" type="checkbox" class="focus:ring-theme-900 h-4 w-4 text-theme-900 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                              <label for="disableNonPriority" class="font-medium">Skýt neprioritní VP</label>
                            </div>
                        </div>
                    @endif

                </div>
                
                <div>
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
            @if ($view == VPsInsight::VIEW_VPS_TABLE)
                <div class="w-full">{{ $vps->links() }}</div>
            @endif
        </div>

        @if ($view == VPsInsight::VIEW_VPS_TABLE)
            <div class="mt-3">
                @foreach ($vps as $key => $vp)
                    <x-molecules.compressed-expandable-card wire:key="{{ $vp->sId }}" class="bg-white">
                        <x-slot name="title">
                            <svg class="h-3 w-3 text-yellow-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="12" fill="currentColor"/>
                            </svg>
                            
                            <a href="{{ route('insights.vp', $vp->sId) }}" title="{{ $vp->sId }}" class="ml-2 font-medium hover:underline">
                                @if($substituted)
                                    {{ $vp->short_id }}
                                @else
                                    {{ $vp->sId }}
                                @endif
                            </a>
                        </x-slot>
        
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
        
                        <div class="mt-6">
                            @if (count($vp->relCooperations()) > 0)
                                <p class="px-2 py-1 bg-theme-600 inline-block font-medium text-xs">Operace</p>
                            @endif
        
                            @foreach ($vp->relFullOperations() as $key => $op)
                                <x-molecules.expandable-card class="bg-white">
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
                        </div>
        
                        @if (count($vp->relCooperations()) > 0)
                            <div class="mt-6">
                                <p class="px-2 py-1 bg-theme-600 inline-block font-medium text-xs">Kooperace</p>
                                @foreach ($vp->relCooperations() as $key => $op)
                                    <x-molecules.expandable-card class="bg-white">
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
                            </div>
                        @endif
                    </x-molecules.compressed-expandable-card>
                @endforeach
            </div>
        @elseif ($view == VPsInsight::VIEW_VPS_GROUPED_BY_PRIORITY)
            <div class="mt-3">
                @foreach ($groups as $priority => $group)
                    <x-molecules.compressed-expandable-card wire:key="priority.group.{{ $priority }}" class="bg-white mb-3">
                        <x-slot name="title">
                            <div class="font-medium">
                                @if ($priority == 0)
                                    <span>Neprioritní</span>
                                @else
                                    Priorita: <span class="ml-2 font-semibold">{{ $priority }}</span>
                                @endif
                            </div>
                        </x-slot>

                        <x-slot name="header">
                            <span class="py-1 px-4 text-xs font-medium bg-theme-300 rounded-full text-theme-900 flex items-center border shadow-inner">
                                Celkem výrobních operací:
                                <span class="ml-2 font-semibold">{{ count($group) }}</span>
                            </span>
                        </x-slot>

                        {{-- {{ $vps->links() }} --}}
        
                        <div class="mt-6 mb-3">
                            @foreach ($group as $key => $vp)
                                <x-molecules.compressed-expandable-card wire:key="{{ 'priority.group.' . $priority . 'vp' . $vp->sId }}" class="bg-white">
                                    <x-slot name="title">
                                        <svg class="h-3 w-3 text-yellow-500" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="12" fill="currentColor"/>
                                        </svg>
                                        
                                        <a href="{{ route('insights.vp', $vp->sId) }}" title="{{ $vp->sId }}" class="ml-2 font-medium hover:underline">
                                            @if($substituted)
                                                {{ $vp->short_id }}
                                            @else
                                                {{ $vp->sId }}
                                            @endif
                                        </a>
                                    </x-slot>
                    
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
                    
                                    <div class="mt-6">
                                        @if (count($vp->relCooperations()) > 0)
                                            <p class="px-2 py-1 bg-theme-600 inline-block font-medium text-xs">Operace</p>
                                        @endif
                    
                                        @foreach ($vp->relFullOperations() as $key => $op)
                                            <x-molecules.expandable-card class="bg-white">
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
                                            </x-molecules.expandable-card>
                                        @endforeach
                                    </div>
                    
                                    @if (count($vp->relCooperations()) > 0)
                                        <div class="mt-6">
                                            <p class="px-2 py-1 bg-theme-600 inline-block font-medium text-xs">Kooperace</p>
                                            @foreach ($vp->relCooperations() as $key => $op)
                                                <x-molecules.expandable-card class="bg-white">
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
                                                </x-molecules.expandable-card>
                                            @endforeach
                                        </div>
                                    @endif
                                </x-molecules.compressed-expandable-card>
                            @endforeach
                        </div>
                    </x-molecules.compressed-expandable-card>
                @endforeach
            </div>
        @endif
    </div>
</div>