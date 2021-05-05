<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Odeslané pozvánky') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            @forelse($invitations as $invitation)
                <div class="flex justify-between bg-theme-300 rounded-md mb-4 px-4 py-2">
                    <span class="font-medium">{{ $invitation->email }}</span>
                    <span class="font-medium">{{ $invitation->token }}</span>
                    <span class="font-medium">{{ $invitation->created_at }}</span>
                </div>
            @empty
    
            @endforelse
        </div>
    </x-slot>

</x-jet-form-section>