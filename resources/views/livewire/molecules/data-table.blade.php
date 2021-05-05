<div>
    <table class="w-full divide-y divide-gray-200 mt-6 border-theme-600 border">
        <thead class="bg-gray-50">
            <tr>
                @foreach($cols as $col => $val)
                    <th wire:key="{{ $col.$val }}" scope="col" class="px-6 py-3 text-left text-xs font-medium text-theme-900 bg-theme-400 uppercase tracking-wider">
                        {{ $val }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($data as $key => $model)
                <tr wire:key="{{$key.$model}}">
                    @foreach($model->getFilteredAttributes() as $key => $attr)
                        <td wire:key="{{ sprintf("%s.%s", $model->getAttribute($model->getKeyName()), $key) }}" class="px-6 py-4 whitespace-nowrap font-medium">
                            {{ $attr }}
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
