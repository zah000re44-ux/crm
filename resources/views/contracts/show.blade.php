@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">

    <div class="bg-white p-6 rounded-xl shadow">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">
                عقد رقم {{ $contract->contract_no ?? '-' }}
            </h1>

            <a href="{{ route('contracts.index') }}"
               class="text-sm text-gray-600 hover:underline">
                رجوع
            </a>
        </div>

        <div class="grid grid-cols-2 gap-6 text-sm">

            <div>
                <p class="text-gray-500">العميل</p>
                <p class="font-semibold">{{ $contract->client->name }}</p>
            </div>

            <div>
                <p class="text-gray-500">الحالة</p>
                <span class="px-2 py-1 rounded-full text-xs bg-gray-100">
                    {{ $contract->status }}
                </span>
            </div>

            <div>
                <p class="text-gray-500">تاريخ البداية</p>
                <p class="font-semibold">
                    {{ $contract->starts_at->format('Y-m-d') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">تاريخ النهاية</p>
                <p class="font-semibold">
                    {{ $contract->ends_at->format('Y-m-d') }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">قيمة العقد</p>
                <p class="font-semibold">
                    {{ number_format($contract->amount, 2) }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">الوكيل</p>
                <p class="font-semibold">
                    {{ $contract->agent->name }}
                </p>
            </div>

        </div>

        @if($contract->notes)
            <div class="mt-6">
                <p class="text-gray-500 text-sm">ملاحظات</p>
                <div class="bg-gray-50 p-3 rounded-lg mt-2 text-sm"> 
                    {{ $contract->notes }}
                </div>
            </div>
        @endif

    </div>

</div>
@endsection
