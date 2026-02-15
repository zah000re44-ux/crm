@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">إنشاء عقد إيجار</h1>

        <a href="{{ $selectedClient ? route('clients.show', $selectedClient) : route('contracts.index') }}"
   class="text-sm text-gray-600 hover:underline">
    ← رجوع
</a>

    </div>

    <form method="POST" action="{{ route('contracts.store') }}" class="space-y-4 bg-white p-6 rounded-xl shadow">
        @csrf

        {{-- العميل --}}
        <div>
            <label class="block text-sm mb-1">العميل</label>
            <select name="client_id" required class="w-full border rounded-lg p-2">
                <option value="">اختر العميل</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}"
                        {{ (isset($selectedClient) && $selectedClient == $client->id) ? 'selected' : '' }}>
                        {{ $client->name }} - {{ $client->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- رقم العقد --}}
        <div>
            <label class="block text-sm mb-1">رقم العقد</label>
            <input type="text" name="contract_no"
                   value="{{ old('contract_no') }}"
                   class="w-full border rounded-lg p-2">
        </div>

        {{-- التواريخ --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">تاريخ البداية</label>
                <input type="date" name="starts_at" required
                       value="{{ old('starts_at') }}"
                       class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label class="block text-sm mb-1">تاريخ النهاية</label>
                <input type="date" name="ends_at" required
                       value="{{ old('ends_at') }}"
                       class="w-full border rounded-lg p-2">
            </div>
        </div>

        {{-- المبلغ --}}
        <div>
            <label class="block text-sm mb-1">قيمة العقد</label>
            <input type="number" step="0.01" name="amount" required
                   value="{{ old('amount') }}"
                   class="w-full border rounded-lg p-2">
        </div>

        {{-- الحالة --}}
        <div>
            <label class="block text-sm mb-1">الحالة</label>
            <select name="status" required class="w-full border rounded-lg p-2">
                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>ساري</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </div>

        {{-- ملاحظات --}}
        <div>
            <label class="block text-sm mb-1">ملاحظات</label>
            <textarea name="notes" rows="3"
                      class="w-full border rounded-lg p-2">{{ old('notes') }}</textarea>
        </div>

        <button type="submit"
                class="bg-black text-white px-4 py-2 rounded-lg hover:opacity-90">
            حفظ العقد
        </button>
    </form>

</div>
@endsection
