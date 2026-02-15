@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-100 rounded-xl']) }}>
    
    @if($title || $subtitle)
        <div class="px-6 py-5 border-b border-gray-100">
            @if($subtitle)
                <div class="text-xs text-gray-400 uppercase tracking-wide">
                    {{ $subtitle }}
                </div>
            @endif

            @if($title)
                <h3 class="text-base font-semibold text-gray-900 mt-1">
                    {{ $title }}
                </h3>
            @endif
        </div>
    @endif

    <div class="px-6 py-6">
        {{ $slot }}
    </div>

</div>
