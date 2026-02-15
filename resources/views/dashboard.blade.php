<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                لوحة التحكم
            </h2>
            <span class="text-sm text-gray-500">CRM Dashboard</span>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 h-full">
                    <div class="flex items-center justify-between text-sm text-gray-500">
                        <span>إجمالي العملاء</span>
                        <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200">👥</span>
                    </div>
                    <div class="mt-3 text-3xl font-extrabold text-gray-900">
                        {{ $totalClients ?? 0 }}
                    </div>
                </div>

                @php
                    $map = [
                        'note' => ['📝', 'ملاحظات اليوم'],
                        'call' => ['📞', 'اتصالات اليوم'],
                        'meeting' => ['📅', 'مواعيد اليوم'],
                        'whatsapp' => ['💬', 'واتساب اليوم'],
                    ];
                @endphp

                @foreach($map as $type => $meta)
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 h-full">
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <span>{{ $meta[1] }}</span>
                            <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200">{{ $meta[0] }}</span>
                        </div>
                        <div class="mt-3 text-3xl font-extrabold text-gray-900">
                            {{ $todayNotesByType[$type]->total ?? 0 }}
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Clients by Status + Latest Clients -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- توزيع الحالة -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm h-full">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">تحليل</div>
                                <h3 class="text-lg font-bold text-gray-900">توزيع العملاء حسب الحالة</h3>
                            </div>
                            <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200 text-sm">📊</span>
                        </div>

                        <div class="mt-4 space-y-4">
                            @php
                                $max = max(1, ($clientsByStatus->max('total') ?? 1));
                            @endphp

                            @forelse($clientsByStatus ?? [] as $row)
                                @php
                                    $percent = intval(($row->total / $max) * 100);
                                    $cls = match($row->status) {
                                        'مهتم' => 'bg-blue-500',
                                        'تفاوض' => 'bg-yellow-500',
                                        'اشترى' => 'bg-green-600',
                                        'مغلق' => 'bg-gray-500',
                                        default => 'bg-gray-400',
                                    };
                                @endphp

                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <div class="font-semibold text-gray-900">{{ $row->status }}</div>
                                        <div class="text-gray-600">{{ $row->total }}</div>
                                    </div>

                                    <div class="mt-2 h-2 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-2 {{ $cls }}" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">لا يوجد بيانات بعد.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- أحدث العملاء -->
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm h-full">
                    <div class="p-6 h-full flex flex-col">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-sm text-gray-500">حديثًا</div>
                                <h3 class="text-lg font-bold text-gray-900">أحدث العملاء</h3>
                            </div>
                            <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200 text-sm">🆕</span>
                        </div>

                        <div class="mt-4 divide-y divide-gray-100">
                            @forelse($latestClients ?? [] as $c)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-900">{{ $c->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $c->phone ?? '-' }}</div>
                                    </div>
                                    <a class="text-sm font-semibold text-blue-600 hover:underline"
                                       href="{{ route('clients.show', $c) }}">
                                        عرض
                                    </a>
                                </div>
                            @empty
                                <div class="py-6 text-sm text-gray-500">لا يوجد عملاء بعد.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Latest Activity -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">النشاط</div>
                        <h3 class="text-lg font-bold text-gray-900">آخر المتابعات</h3>
                    </div>
                    <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200 text-sm">⚡</span>
                </div>

                <div class="p-6">
                    <div class="space-y-3">
                        @forelse($latestNotes ?? [] as $note)
                            <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm">
                                <div class="flex items-center justify-between flex-wrap gap-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-1 rounded-lg bg-gray-50 border border-gray-200">
                                            @if($note->type === 'call') 📞 اتصال
                                            @elseif($note->type === 'meeting') 📅 موعد
                                            @elseif($note->type === 'whatsapp') 💬 واتساب
                                            @else 📝 ملاحظة
                                            @endif
                                        </span>

                                        <span class="font-semibold text-gray-900">
                                            {{ $note->user->name ?? '—' }}
                                        </span>

                                        <span class="text-gray-400">
                                            • {{ $note->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </div>

                                    @if(isset($note->client))
                                        <a class="text-blue-600 font-semibold hover:underline"
                                           href="{{ route('clients.show', $note->client) }}">
                                            {{ $note->client->name }}
                                        </a>
                                    @endif
                                </div>

                                <div class="mt-2 text-gray-800 whitespace-pre-line">
                                    {{ $note->content }}
                                </div>
                            </div>
                        @empty
                            <div class="text-sm text-gray-500">لا توجد متابعات بعد.</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
