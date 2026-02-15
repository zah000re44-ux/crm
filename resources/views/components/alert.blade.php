@props([
    'type' => 'success', // success | error | info
])

@php
    $map = [
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'error' => 'border-red-200 bg-red-50 text-red-800',
        'info' => 'border-blue-200 bg-blue-50 text-blue-800',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl border p-4 '.($map[$type] ?? $map['info'])]) }}>
    {{ $slot }}
</div>
