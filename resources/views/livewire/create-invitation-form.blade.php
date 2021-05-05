<div x-data="{sent: @entangle('emailSent')}">
    <x-jet-form-section submit="send">
        <x-slot name="title">
            {{ __('Zaslat pozvánku k registraci') }}
        </x-slot>
    
        <x-slot name="description">
            {{ __('Zašlete uživateli pozvánku k vytvoření účtu.') }}
        </x-slot>
    
        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="email" value="{{ __('E-mailová adresa') }}" />
                <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="email" autocomplete="email" />
                <x-jet-input-error for="email" class="mt-2" />
            </div>
        </x-slot>
    
        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="send">
                {{ __('Odesláno.') }}
            </x-jet-action-message>
    
            <x-jet-button>
                {{ __('Odeslat') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>

    <div x-cloak x-show="sent" x-init="setTimeout(() => sent = false, 3000)" class="z-30 absolute bottom-6 right-6 flex justify-between items-center py-3 px-6 text-sm bg-green-200 text-green-800 rounded shadow-md"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform translate-x-8"
        x-transition:enter-end="opacity-100 transform translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-x-0"
        x-transition:leave-end="opacity-0 transform translate-x-8">
        <div class="flex items-center">
            Pozvánka úspěšně odeslána
        </div>
    </div>
</div>