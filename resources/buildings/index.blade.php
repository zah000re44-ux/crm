<x-app-layout>
    <x-page-header title="المباني" :actions="[
        ['label' => 'إضافة مبنى', 'href' => route('buildings.create')]
    ]"/>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($buildings as $b)
            <a href="{{ route('buildings.show', $b) }}" class="block rounded-xl border bg-white p-4 hover:shadow">
                <div class="font-semibold">{{ $b->name }}</div>
                <div class="mt-1 text-sm text-gray-600">
                    {{ $b->city ?? '—' }} • {{ $b->district ?? '—' }}
                </div>
                <div class="mt-3 inline-flex items-center rounded-full bg-gray-100 px-2 py-1 text-xs">
                    الوحدات: {{ $b->units_count }}
                </div>
            </a>
        @endforeach
    </div>

    <div class="mt-6">{{ $buildings->links() }}</div>
</x-app-layout>
