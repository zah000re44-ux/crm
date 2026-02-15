<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                تفاصيل العميل
            </h2>

            <a href="{{ route('clients.index') }}">
                <x-btn variant="secondary">رجوع للقائمة</x-btn>
            </a>
        </div>
    </x-slot>

    <div class="py-6 bg-gradient-to-b from-gray-50 to-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Alerts --}}
            @if (session('status'))
                <x-alert type="success">{{ session('status') }}</x-alert>
            @endif

            @if ($errors->any())
                <x-alert type="error">
                    <ul class="list-disc pr-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif


            {{-- بيانات العميل --}}
<x-card title="بيانات العميل" icon="👤">

    @php
        $cls = match($client->status) {
            'مهتم' => 'bg-blue-100 text-blue-800',
            'تفاوض' => 'bg-yellow-100 text-yellow-800',
            'اشترى' => 'bg-green-100 text-green-800',
            'مغلق' => 'bg-gray-200 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    @endphp

    {{-- عقود الإيجار --}}
<div class="mt-8 bg-white p-6 rounded-xl shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">عقود الإيجار</h2>

        <a href="{{ route('contracts.create', ['client_id' => $client->id]) }}"
           class="bg-black text-white px-3 py-1.5 rounded-lg text-sm hover:opacity-90">
            + عقد جديد
        </a>
    </div>

    @if($client->contracts->count())
        <table class="w-full text-sm text-right">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2">رقم العقد</th>
                    <th class="p-2">تاريخ البداية</th>
                    <th class="p-2">تاريخ النهاية</th>
                    <th class="p-2">المبلغ</th>
                    <th class="p-2">الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($client->contracts as $contract)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2">
                            <a href="{{ route('contracts.show', $contract) }}"
                               class="text-blue-600 hover:underline">
                                {{ $contract->contract_no ?? '-' }}
                            </a>
                        </td>
                        <td class="p-2">
                            {{ $contract->starts_at->format('Y-m-d') }}
                        </td>
                        <td class="p-2">
                            {{ $contract->ends_at->format('Y-m-d') }}
                        </td>
                        <td class="p-2">
                            {{ number_format($contract->amount,2) }}
                        </td>
                        <td class="p-2">
                            <span class="px-2 py-1 rounded-full text-xs bg-gray-100">
                                {{ $contract->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-gray-500 text-sm">
            لا يوجد عقود لهذا العميل
        </div>
    @endif
</div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

        <div>
            <div class="text-gray-500">الاسم</div>
            <div class="font-semibold text-gray-900">{{ $client->name }}</div>
        </div>

        <div>
            <div class="text-gray-500">الجوال</div>
            <div class="font-semibold text-gray-900">{{ $client->phone ?? '-' }}</div>
        </div>

        <div>
            <div class="text-gray-500">الإيميل</div>
            <div class="font-semibold text-gray-900">{{ $client->email ?? '-' }}</div>
        </div>

        <div>
            <div class="text-gray-500">المصدر</div>
            <div class="font-semibold text-gray-900">{{ $client->source ?? '-' }}</div>
        </div>

        <div>
            <div class="text-gray-500">الموظف المسؤول</div>
            <div class="font-semibold text-gray-900">
                {{ optional($client->assignedTo)->name ?? '-' }}
            </div>
        </div>

        <div>
            <div class="text-gray-500 mb-1">الحالة الحالية</div>

            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $cls }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                {{ $client->status }}
            </span>

            {{-- تحديث الحالة --}}
            <form method="POST"
                  action="{{ route('clients.status.update', $client) }}"
                  class="mt-3">
                @csrf
                @method('PATCH')

                <select name="status"
                        onchange="this.form.submit()"
                        class="mt-1 w-full rounded-lg border-gray-200 text-sm focus:border-gray-900 focus:ring-gray-900">
                    <option value="مهتم" @selected($client->status==='مهتم')>مهتم</option>
                    <option value="تفاوض" @selected($client->status==='تفاوض')>تفاوض</option>
                    <option value="اشترى" @selected($client->status==='اشترى')>اشترى</option>
                    <option value="مغلق" @selected($client->status==='مغلق')>مغلق</option>
                </select>

                <div class="text-xs text-gray-400 mt-1">
                    يتم الحفظ تلقائيًا عند التغيير
                </div>
            </form>

        </div>

    </div>

</x-card>



            {{-- Timeline --}}
            <x-card title="سجل المتابعة" subtitle="Timeline" icon="📝">

                {{-- إضافة متابعة --}}
                <form method="POST" action="{{ route('clients.notes.store', $client) }}" class="space-y-4 mb-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-select label="نوع المتابعة" name="type" required>
                            <option value="note">📝 ملاحظة</option>
                            <option value="call">📞 اتصال</option>
                            <option value="meeting">📅 موعد</option>
                            <option value="whatsapp">💬 واتساب</option>
                        </x-select>
                    </div>

                    <x-textarea label="التفاصيل" name="content" rows="3" required />

                    <div class="flex justify-end">
                        <x-btn type="submit">إضافة متابعة</x-btn>
                    </div>
                </form>


                {{-- عرض المتابعات --}}
                <div class="space-y-3">
                    @forelse ($client->notes->sortByDesc('id') as $note)

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
                            </div>

                            <div class="mt-2 text-gray-800 whitespace-pre-line">
                                {{ $note->content }}
                            </div>

                        </div>

                    @empty
                        <div class="text-sm text-gray-500">
                            لا توجد متابعات حتى الآن.
                        </div>
                    @endforelse
                </div>

            </x-card>

        </div>
    </div>
</x-app-layout>
