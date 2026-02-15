@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
        <h1 class="text-2xl font-bold">العقود</h1>

        <a href="{{ route('contracts.create') }}"
           class="inline-flex items-center justify-center bg-black text-white px-4 py-2 rounded-lg hover:opacity-90">
            + عقد جديد
        </a>
    </div>

    <div class="bg-white shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-[900px] w-full text-sm text-right">
                <thead class="bg-gray-50">
                    <tr class="whitespace-nowrap">
                        <th class="p-3">رقم العقد</th>
                        <th class="p-3">العميل</th>
                        <th class="p-3">تاريخ البداية</th>
                        <th class="p-3">تاريخ النهاية</th>
                        <th class="p-3">المبلغ</th>
                        <th class="p-3">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($contracts as $contract)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 whitespace-nowrap">
                                <a href="{{ route('contracts.show', $contract) }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $contract->contract_no ?? '-' }}
                                </a>
                            </td>
                            <td class="p-3 whitespace-nowrap">{{ $contract->client->name }}</td>
                            <td class="p-3 whitespace-nowrap">{{ optional($contract->starts_at)->format('Y-m-d') ?? '-' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ optional($contract->ends_at)->format('Y-m-d') ?? '-' }}</td>
                            <td class="p-3 whitespace-nowrap">{{ is_null($contract->amount) ? '-' : number_format($contract->amount, 2) }}</td>
                            <td class="p-3 whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-gray-100">
                                    {{ $contract->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-500">
                                لا يوجد عقود حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $contracts->links() }}
    </div>

</div>
@endsection
