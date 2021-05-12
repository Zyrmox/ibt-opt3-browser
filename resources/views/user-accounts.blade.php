<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-theme-900 leading-tight">
            {{ __('Uživatelské účty') }}
        </h2>
    </x-slot>

    <div>
        <div class="container mx-auto pb-12">
            @livewire('organisms.create-invitation-form')

            <x-jet-section-border />

            {{-- @livewire('organisms.invitations-form') --}}
        </div>
    </div>
</x-app-layout>
