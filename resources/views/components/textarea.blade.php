@props([
    'label' => null,
    'rows' => 3,
])

<label class="block">
    @if($label)
        <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
    @endif

    <textarea
        rows="{{ $rows }}"
        {{ $attributes->merge([
            'class' => 'mt-1 w-full rounded-xl border-gray-200 focus:border-gray-900 focus:ring-gray-900'
        ]) }}
    >{{ $slot }}</textarea>
</label>
