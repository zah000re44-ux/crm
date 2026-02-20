<x-app-layout>
    <x-page-header title="إضافة مبنى" />

    <form method="POST" action="{{ route('buildings.store') }}" class="max-w-xl rounded-xl border bg-white p-6">
        @csrf

        <x-input label="اسم المبنى" name="name" required />
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="المدينة" name="city" />
            <x-input label="الحي" name="district" />
        </div>

        <div class="mt-4">
            <x-input label="العنوان" name="address" />
        </div>

        <div class="mt-6 flex gap-2">
            <x-button type="submit">حفظ</x-button>
            <a class="rounded-lg border px-4 py-2" href="{{ route('buildings.index') }}">إلغاء</a>
        </div>
    </form>
</x-app-layout>
