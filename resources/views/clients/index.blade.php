<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">العملاء</h2>
            <span class="text-sm text-gray-500">CRM</span>
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

            {{-- إضافة عميل --}}
            <x-card title="إضافة عميل" icon="➕">
                <form method="POST" action="{{ route('clients.store') }}"
                      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @csrf

                    <x-input label="الاسم *" name="name" required />
                    <x-input label="الجوال" name="phone" />
                    <x-input label="الإيميل" name="email" type="email" />

                    <x-input label="المصدر" name="source" placeholder="إعلان، توصية..." />

                    {{-- الحقول العقارية الجديدة --}}
                    <x-input label="البناية" name="building_name" placeholder="اسم/رقم البناية..." />
                    <x-input label="الحي" name="district" placeholder="مثال: الروضة، العليا..." />
                    <x-input label="صاحب البناية" name="building_owner" placeholder="اسم المالك..." />

                    {{-- حالات مناسبة للبيع + التأجير --}}
                    <x-select label="الحالة" name="status" required>
                        <option value="جديد" @selected(old('status')==='جديد')>جديد</option>
                        <option value="تم التواصل" @selected(old('status')==='تم التواصل')>تم التواصل</option>
                        <option value="معاينة" @selected(old('status')==='معاينة')>معاينة</option>
                        <option value="عرض سعر" @selected(old('status')==='عرض سعر')>عرض سعر</option>
                        <option value="تفاوض" @selected(old('status')==='تفاوض')>تفاوض</option>
                        <option value="تم التعاقد" @selected(old('status')==='تم التعاقد')>تم التعاقد</option>
                        <option value="مغلق - تم" @selected(old('status')==='مغلق - تم')>مغلق - تم</option>
                        <option value="مغلق - ملغي" @selected(old('status')==='مغلق - ملغي')>مغلق - ملغي</option>
                    </x-select>

                    <x-select label="الموظف المسؤول" name="assigned_to">
                        <option value="">بدون</option>
                        @foreach($agents as $a)
                            <option value="{{ $a->id }}" @selected((string)old('assigned_to') === (string)$a->id)>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <div class="lg:col-span-3 md:col-span-2 flex justify-end">
                        <x-btn type="submit">إضافة العميل</x-btn>
                    </div>
                </form>
            </x-card>

            {{-- قائمة العملاء --}}
            <x-card title="قائمة العملاء" subtitle="إدارة" icon="📋">

                {{-- فلترة --}}
                <form method="GET" action="{{ route('clients.index') }}" class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                        <div class="md:col-span-2">
                            <x-input
                                label="بحث"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="ابحث بالاسم أو الجوال أو الإيميل..."
                            />
                        </div>

                        {{-- فلتر الحالة (مو required + فيه الكل + يحافظ على الاختيار) --}}
                        <x-select label="الحالة" name="status">
                            <option value="">الكل</option>
                            <option value="جديد" @selected(request('status')==='جديد')>جديد</option>
                            <option value="تم التواصل" @selected(request('status')==='تم التواصل')>تم التواصل</option>
                            <option value="معاينة" @selected(request('status')==='معاينة')>معاينة</option>
                            <option value="عرض سعر" @selected(request('status')==='عرض سعر')>عرض سعر</option>
                            <option value="تفاوض" @selected(request('status')==='تفاوض')>تفاوض</option>
                            <option value="تم التعاقد" @selected(request('status')==='تم التعاقد')>تم التعاقد</option>
                            <option value="مغلق - تم" @selected(request('status')==='مغلق - تم')>مغلق - تم</option>
                            <option value="مغلق - ملغي" @selected(request('status')==='مغلق - ملغي')>مغلق - ملغي</option>
                        </x-select>

                        <x-select label="المسؤول" name="assigned_to">
                            <option value="">الكل</option>
                            @foreach($agents as $a)
                                <option value="{{ $a->id }}"
                                    @selected((string)request('assigned_to') === (string)$a->id)>
                                    {{ $a->name }}
                                </option>
                            @endforeach
                        </x-select>
                    </div>

                    <div class="mt-4 flex justify-end gap-2">
                        <x-btn variant="secondary"
                               onclick="window.location='{{ route('clients.index') }}'; return false;">
                            تصفير
                        </x-btn>

                        <x-btn type="submit">تطبيق</x-btn>
                    </div>
                </form>

                {{-- الجدول --}}
                <div class="overflow-x-auto rounded-2xl border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr class="text-right text-xs font-semibold text-gray-600">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">الاسم</th>
                                <th class="px-4 py-3">الجوال</th>
                                <th class="px-4 py-3">الحالة</th>
                                <th class="px-4 py-3">المسؤول</th>
                                <th class="px-4 py-3 text-center">إجراء</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($clients as $c)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $c->id }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $c->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $c->phone ?? '-' }}</td>

                                    <td class="px-4 py-3">
                                        @php
                                            $cls = match($c->status) {
                                                'جديد' => 'bg-slate-100 text-slate-800',
                                                'تم التواصل' => 'bg-indigo-100 text-indigo-800',
                                                'معاينة' => 'bg-cyan-100 text-cyan-800',
                                                'عرض سعر' => 'bg-purple-100 text-purple-800',
                                                'تفاوض' => 'bg-yellow-100 text-yellow-800',
                                                'تم التعاقد' => 'bg-emerald-100 text-emerald-800',
                                                'مغلق - تم' => 'bg-green-100 text-green-800',
                                                'مغلق - ملغي' => 'bg-gray-200 text-gray-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };
                                        @endphp

                                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $cls }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current opacity-60"></span>
                                            {{ $c->status }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ optional($c->assignedTo)->name ?? '-' }}
                                    </td>

                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('clients.show', $c) }}">
                                            <x-btn variant="secondary">عرض</x-btn>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                        لا يوجد عملاء بعد — ابدأ بإضافة أول عميل 👆
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </x-card>

        </div>
    </div>
</x-app-layout>
