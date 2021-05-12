<div>
    <!--
        Log Opts (Settings) View - Fullpage Livewire Component
        Controller for this component: App/Http/Livewire/Pages/Insights/LogOpts.php
    
        Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
    -->
    <x-slot name="header">
        <h2 class="font-semibold text-2xl sticky">
            {{ __('LogOpts') }}
        </h2>
    </x-slot>
    
    <div class="container mx-auto">

        <div>
            <table class="w-full divide-y divide-gray-200 border-theme-600 text-sm border table-fixed">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($attributes as $key => $val)
                            <th scope="col" class="sticky top-0 px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                                <div class="flex items-center justify-between">
                                    {{ $key }}
                                    @if ($key == 'optChar')
                                        <input wire:model.debounce.250ms="search" type="text" class="border-1 border-theme-400 bg-white h-10 px-5 pr-12 rounded text-sm focus:outline-none relative" placeholder="Hledat optChar">
                                    @endif
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logOpts as $logOpt)
                        <tr>
                            @foreach($logOpt->getFilteredAttributes() as $val)
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    {{ $val != null ? $val : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <div class="p-3">
                            <span>Nenalezeny žádné záznamy<span>
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>