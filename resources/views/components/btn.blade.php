@props([
    'variant' => 'primary',
    'type' => 'button',
    'icon' => false,
])

@php
    $base = 'inline-flex items-center justify-center rounded-lg text-sm font-medium transition';

    if($icon) {
        $base .= ' w-9 h-9';
    } else {
        $base .= ' px-4 py-2';
    }

    $variants = [
        'primary' => 'bg-black text-white hover:opacity-90',
        'secondary' => 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50',
        'danger' => 'bg-white border border-gray-200 text-gray-500 hover:text-red-700 hover:border-red-300 transition-colors duration-150',

    ];
@endphp

<button type="{{ $type }}"
        {{ $attributes->merge(['class' => $base.' '.($variants[$variant] ?? $variants['primary'])]) }}>
    {{ $slot }}
</button>
