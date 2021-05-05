<div {{ $attributes->merge(['class' => 'relative bg-white']) }} x-data="{ expanded: {{ $expanded ? 'true' : 'false'}} }">
    <tr @click="expanded = !expanded">
        {{-- <td class="bg-red-500">
            <button class="px-2 py-2 bg-gray-600 bg-opacity-0 hover:bg-opacity-5 rounded-full mr-4 focus:outline-none" @click="expanded = !expanded">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path x-cloak x-show="!expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                    <path x-cloak x-show="expanded" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </td> --}}
        <td></td>
        {{ $title }}
    </tr>
    <tr x-show="expanded" x-cloak class="min-w-full overflow-x-auto bg-red-400 px-4 pb-3">
        {{ $slot }}
    </tr>
</div>
