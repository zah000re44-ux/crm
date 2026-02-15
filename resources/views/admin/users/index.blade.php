<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                إدارة المستخدمين
            </h2>
            <span class="text-sm text-gray-500">Admin Panel</span>
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


            {{-- إضافة مستخدم --}}
            <x-card title="إضافة مستخدم" icon="➕">

                <form method="POST" action="{{ route('admin.users.store') }}"
                      class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <x-input label="الاسم" name="name" required />

                    <x-input label="الإيميل" name="email" type="email" required />

                    <x-input label="كلمة المرور" name="password" type="password" required />

                    <x-select label="الدور" name="role" required>
                        <option value="agent">موظف (Agent)</option>
                        <option value="admin">مدير (Admin)</option>
                    </x-select>

                    <div class="md:col-span-2 flex justify-end">
                        <x-btn type="submit">إضافة المستخدم</x-btn>
                    </div>

                </form>

            </x-card>


            {{-- جدول المستخدمين --}}
            <x-card title="المستخدمون" subtitle="إدارة الصلاحيات" icon="👥">

                <div class="overflow-x-auto rounded-2xl border border-gray-200">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr class="text-right text-xs font-semibold text-gray-600">
                                <th class="px-4 py-3">#</th>
                                <th class="px-4 py-3">الاسم</th>
                                <th class="px-4 py-3">الإيميل</th>
                                <th class="px-4 py-3">الدور</th>
                                <th class="px-4 py-3 text-center">إجراء</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse ($users as $u)

                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $u->id }}
                                    </td>

                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">
                                        {{ $u->name }}
                                    </td>

                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ $u->email }}
                                    </td>

                                    <td class="px-4 py-3">

                                        @php
                                            $roleCls = $u->role === 'admin'
                                                ? 'bg-red-100 text-red-800'
                                                : 'bg-gray-100 text-gray-800';
                                        @endphp

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $roleCls }}">
                                            {{ ucfirst($u->role) }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 text-center">

                                        @if(auth()->user()->role === 'admin')

                                            <form method="POST"
                                                  action="{{ route('admin.users.destroy', $u) }}"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف المستخدم؟');">
                                                @csrf
                                                @method('DELETE')

                                                <x-btn variant="danger" icon type="submit" title="حذف المستخدم">

                                                       🗑
                                                </x-btn>
                                            </form>

                                        @else
                                            <span class="text-xs text-gray-400">—</span>
                                        @endif

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-sm text-gray-500">
                                        لا يوجد مستخدمين بعد.
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
