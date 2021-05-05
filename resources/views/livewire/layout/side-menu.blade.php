<div class="flex w-2/5" x-data="{ showSidebar: true }" x-show="showSidebar">
    <aside class="w-2/5">
        <div class="bg-theme-900 min-h-screen pt-12 px-6 flex flex-col justify-between">
            <nav class="flex flex-col w-full">
                <button wire:click="changeSubMenu('insights')" class="focus:outline-none items-start flex text-lg font-semibold my-2 {{ $currentTab == 'insights' ? "text-white" : 'text-gray-400' }}">
                    {{ __('Pohledy') }}
                </button>
    
                <button wire:click="changeSubMenu('database-files')" class="focus:outline-none items-start flex text-lg font-semibold my-2 {{ $currentTab == 'database-files' ? "text-white" : 'text-gray-400' }}">
                    {{ __('Databázové soubory') }}
                </button>
            </nav>

            <div class="bg-white -mx-6 py-4">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profil') }}
                    </x-jet-responsive-nav-link>

                    <!-- Accounts Management -->
                    <x-jet-responsive-nav-link href="{{ route('user.accounts') }}" :active="request()->routeIs('user.acounts')">
                        {{ __('Uživatelské účty') }}
                    </x-jet-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-jet-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();"
                                    class="text-red-500 hover:text-red-700">
                            {{ __('Odhlásit se') }}
                        </x-jet-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Team') }}
                        </div>

                        <!-- Team Settings -->
                        <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                            {{ __('Team Settings') }}
                        </x-jet-responsive-nav-link>

                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                            <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                                {{ __('Create New Team') }}
                            </x-jet-responsive-nav-link>
                        @endcan

                        <div class="border-t border-gray-200"></div>

                        <!-- Team Switcher -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </aside>
    <aside x-data="{ secondaryMenuOpen: true, currentTab: @entangle('currentTab'), showDeleteConfirmationModal: false, deletedDatabaseFileId: null }" x-cloak x-show="secondaryMenuOpen" class="w-3/5">
        <div class="bg-theme-400 h-screen relative">
           
            <ul class="pt-12 px-6 flex flex-col" x-cloak x-show="currentTab == 'insights'">
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.vp-deadlines">Deadlines</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.vps">Výrobní příkazy</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.jobs">Výrobní operace</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.resources">Zdroje v úloze</x-atoms-secondary-sidebar-link>
                </li>
                {{-- <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link>Kalendář dostupnosti zdrojů</x-atoms-secondary-sidebar-link>
                </li> --}}
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.job-resources">Požadavky operací na zdroje</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.materials">Materiály v úloze</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.c-props">CProp</x-atoms-secondary-sidebar-link>
                </li>
                <li class="flex items-center">
                    <x-atoms.secondary-sidebar-link route="insights.log-opts">LogOpts</x-atoms-secondary-sidebar-link>
                </li>
            </ul>
        
            <div x-cloak x-show="currentTab == 'database-files'" class="flex flex-col justify-between h-full pb-12">
                <div class="mt-12 pb-8 px-6">
                    <form wire:submit.prevent="search" class="relative flex flex-col">
                        <div class="mb-3">
                            <select wire:model="filter" name="filter" class="w-full font-medium rounded-md focus:outline-none bg-theme-300 border-none h-12 text-sm">
                                @foreach ($filterToggle as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-center">
                            <input wire:model.debounce.250ms="search" type="text" class="w-full border-1 border-theme-400 bg-white h-12 px-5 pr-12 rounded text-sm focus:outline-none relative" placeholder="Název souboru">
                            <button type="submit" class="absolute flex items-center justify-center right-4 w-10 h-10 focus:outline-none hover:bg-theme-400 rounded-full">
                                <svg wire:loading.remove wire:target="search" class="text-gray-600 h-full w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            <div wire:loading wire:target="search" class="lds-facebook"><div></div><div></div><div></div></div>
                        </div>
                    </form>
                </div>
                <div class="max-h-full h-full overflow-y-auto">
                    <div class="pt-12 pb-6 px-6">
                        @forelse($files as $db_file)
                            <div class="flex items-center" wire:key="{{ $db_file->url }}">
                                <div class="relative flex justify-between w-full px-6 py-5 mb-4 text-sm rounded-md font-semibold uppercase transition-colors {{ $db_file->isSelected() ? 'bg-white' : 'bg-theme-300' }} hover:bg-white">
                                    <div class="flex flex-col">
                                        {{-- <a wire:click.prevent="switchDatabase({{ $db_file->id }})" class="absolute top-0 right-0 left-0 bottom-0 cursor-pointer"></a> --}}
                                        <p>{{ $db_file->name() }}</p>
                                        <p class="text-xs text-gray-400 mt-2">{{ dateFromDateTime($db_file->created_at) }}</p>
                                        <p class="text-xs text-gray-400">{{ $db_file->user->name }}</p>
                                    </div>

                                    
                                    <!-- This example requires Tailwind CSS v2.0+ -->
                                    <div class="relative inline-block text-left" x-data="{ dropdownOpened: false }" wire:ignore>
                                        <div>
                                            <button x-on:click="dropdownOpened = !dropdownOpened" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="options-menu" aria-expanded="true" aria-haspopup="true">
                                                <!-- Heroicon name: solid/chevron-down -->
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    
                                        <!--
                                        Dropdown menu, show/hide based on menu state.
                                    
                                        Entering: "transition ease-out duration-100"
                                            From: "transform opacity-0 scale-95"
                                            To: "transform opacity-100 scale-100"
                                        Leaving: "transition ease-in duration-75"
                                            From: "transform opacity-100 scale-100"
                                            To: "transform opacity-0 scale-95"
                                        -->
                                        <div
                                            x-show="dropdownOpened"
                                            x-on:click.away="dropdownOpened = false"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="overflow-hidden origin-top-right absolute z-20 right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none"
                                            role="menu"
                                            aria-orientation="vertical"
                                            aria-labelledby="dropdown-menu">

                                            @if(!$db_file->isSelected())
                                                <div class="flex justify-between items-center w-full hover:bg-gray-100 hover:text-gray-900 text-sm" role="none">
                                                    <a href="" wire:click.prevent="switchDatabase({{ $db_file->id }})" class="w-full flex items-center px-4 py-3" role="menuitem">
                                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                                        </svg>
                                                        Připojit se
                                                    </a>
                                                    <div wire:loading wire:target="switchDatabase" class="px-4"><div class="lds-facebook"><div></div><div></div><div></div></div></div>
                                                </div>
                                            @endif
                                            <div class="flex justify-between items-center w-full hover:bg-gray-100 hover:text-gray-900 text-sm" role="none">
                                                <a href="#" wire:click.prevent="downloadDatabase({{ $db_file->id }})" class="w-full flex items-center px-4 py-3" role="menuitem">
                                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Stáhnout
                                                </a>
                                                <div wire:loading wire:target="downloadDatabase" class="px-4"><div class="lds-facebook"><div></div><div></div><div></div></div></div>
                                            </div>
                                            @if ($db_file->isOwner())
                                                <div class="flex justify-between items-center w-full text-red-500 hover:bg-red-100 hover:text-red-800 text-sm" role="none">
                                                    <a href="#" x-on:click.prevent="$dispatch('show-delete-confirmation-modal', { id: {{ $db_file->id }} })" class="w-full flex items-center px-4 py-3" role="menuitem">
                                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Smazat
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="flex w-full text-sm items-center">
                                Žádné nahrané soubory
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="px-6 pt-6">
                    <form wire:submit.prevent="save">
                        <div
                            x-data="{ uploading: false, progress: 0 }"
                            x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false; $wire.save();"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
    
                            <!-- File Input -->
                            <input type="file" wire:model="file" id="upload{{ $iteration }}" class="py-2">
    
                            <!-- Progress Bar -->
                            <div x-show="uploading" x-cloak class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 rounded-full text-theme-300 bg-theme-900">
                                        Nahrávání souboru
                                    </span>
                                    </div>
                                    <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-theme-900">
                                        <span x-text="progress"></span>%
                                    </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-theme-600">
                                    <div :style="`width: ${progress}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                                </div>
                            </div>
    
                            @error('file')
                                <span class="flex justify-between items-center py-3 px-6 mt-6 text-red-800 bg-red-100 rounded shadow-md"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform translate-x-8"
                                x-transition:enter-end="opacity-100 transform translate-x-0">{{ $message }}</span>
                            @enderror
                            <button type="submit" x-cloak x-show="!uploading" class="bg-theme-900 py-4 px-6 mt-4 font-semibold uppercase text-sm text-white flex items-center rounded w-full">
                                <span class="pr-4 border-r-2 border-white border-opacity-40 w-full text-left">Nahrát soubor</span>
                                <svg class="ml-5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <div x-on:show-delete-confirmation-modal.window="deletedDatabaseFileId = $event.detail.id; showDeleteConfirmationModal = true;" x-show="showDeleteConfirmationModal" x-cloak class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!--
                Background overlay, show/hide based on modal state.
        
                Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-50 transition-opacity" aria-hidden="true"></div>
        
            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
            <!--
                Modal panel, show/hide based on modal state.
        
                Entering: "ease-out duration-300"
                From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                To: "opacity-100 translate-y-0 sm:scale-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100 translate-y-0 sm:scale-100"
                To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <!-- Heroicon name: outline/exclamation -->
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Smazat databázový soubor
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                        Opravdu si přejete smazat databázový soubor? Dojde k permanentnímu smazání souboru z uložiště. Tato akce je nevratná.
                        </p>
                    </div>
                    </div>
                </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button x-on:click="$wire.deleteDatabase(deletedDatabaseFileId); showDeleteConfirmationModal = false;" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none ring-theme-500 focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Smazat
                </button>
                <button x-on:click="showDeleteConfirmationModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none ring-red-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Zpět
                </button>
                </div>
            </div>
            </div>
        </div>
    </aside>
</div>
