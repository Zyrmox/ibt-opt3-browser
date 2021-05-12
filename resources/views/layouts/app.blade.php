<!--
	Main Application Layout - Blade Template
	Author: Petr Vrtal (xvrtal01@stud.fit.vutbr.cz)
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SQLite OPT3 Browser') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <!-- Stack For all the styles pushed from subviews  -->
        @stack('styles')

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
        <main class="flex">
            <!-- Side Menu (Composed of both Side Menu & Context Menu) -->
            <livewire:organisms.side-menu />
    
            <div class="relative min-h-screen h-screen bg-gray-100 w-full overflow-hidden">
                <div class="min-h-full max-h-screen overflow-y-auto px-6">
                    <div class="container mx-auto">
                        @if (!dbListEmpty())
                            <!-- Navigation Bar -->
                            <div class="flex justify-between pt-12">
                                <!-- Global Search Bar -->
                                <livewire:organisms.global-search-bar />
                                <!-- Substitution Toggle -->
                                <livewire:molecules.substitution-toggle />
                            </div>
                        @endif
    
                        <!-- Error Message Toast -->
                        @if (session()->has('error'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" class="absolute top-12 w-1/2 right-6">
                                <div x-show="show" class="flex justify-between items-center py-3 px-6 text-red-800 bg-red-100 rounded shadow-md"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform translate-x-8"
                                    x-transition:enter-end="opacity-100 transform translate-x-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform translate-x-0"
                                    x-transition:leave-end="opacity-0 transform translate-x-8">
                                    <div class="flex items-center">
                                        <svg class="h-4 w-4 mr-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
    
                                        {{ session('error') }}
                                    </div>
                                    <button @click="show = !show" role="button" class="hover:bg-red-200 p-1 focus:outline-none rounded-full">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif
    
                        <!-- Page Content -->
                        <header class="pt-12 header flex justify-between items-center">
                            {{ $header }}
                        </header>
                        <div class="py-12 text-sm">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Stack for all Modals pushed from subviews -->
        @stack('modals')

        <!-- Livewire Scripts to bootstrap it's frontend functionality -->
        @livewireScripts

        <!-- Stack For all the <scripts> pushed from subviews  -->
        @stack('scripts')
    </body>
</html>
