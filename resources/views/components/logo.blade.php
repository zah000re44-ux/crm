@props(['size' => 'md'])

@php
    $box = match($size) {
        'sm' => 'w-8 h-8 text-base',
        'lg' => 'w-12 h-12 text-xl',
        default => 'w-10 h-10 text-lg',
    };
    $title = match($size) {
        'sm' => 'text-lg',
        'lg' => 'text-2xl',
        default => 'text-xl',
    };
@endphp

<div class="flex items-center gap-3">
    <div class="{{ $box }} rounded-xl bg-gray-900 text-white flex items-center justify-center font-extrabold">
        R
    </div>
    <div class="leading-tight">
        <div class="{{ $title }} font-extrabold text-gray-900">Real Estate CRM</div>
        <div class="text-xs text-gray-500">إدارة العملاء العقاريين</div>
    </div>
</div>
