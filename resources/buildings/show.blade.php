<x-app-layout>
    <x-page-header :title="$building->name" :actions="[
        ['label' => 'إضافة وحدة', 'href' => route('buildings.units.create', $building)]
    ]"/>

    <div class="rounded-xl border bg-white p-4">
        <div class="text-sm text-gray-600">
            {{ $building->city ?? '—' }} • {{ $building->district ?? '—' }} • {{ $building->address ?? '—' }}
        </div>
    </div>

    <div class="mt-6 rounded-xl border bg-white">
        <div class="border-b p-4 font-semibold">الوحدات</div>

        <div class="divide-y">
            @forelse($building->units as $u)
                <div class="p-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium">{{ $u->name }}</div>
                        <div class="text-sm text-gray-600">
                            {{ $u->unit_number ?? '—' }} • {{ $u->floor ?? '—' }} • {{ $u->rent_price ? number_format($u->rent_price) . ' ر.س' : '—' }}
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        العقود: {{ $u->contracts_count ?? $u->contracts()->count() }}
                    </div>
                </div>
            @empty
                <div class="p-4 text-sm text-gray-600">لا يوجد وحدات بعد.</div>
            @endforelse
        </div>
    </div>
</x-app-layout>
