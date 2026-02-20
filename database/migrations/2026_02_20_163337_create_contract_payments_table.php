<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contract_id')->constrained()->cascadeOnDelete();

            // فترة الدفعة
            $table->date('period_start');
            $table->date('period_end');

            // تاريخ الاستحقاق (عادة بداية الفترة أو تاريخ محدد)
            $table->date('due_date');

            // تفاصيل المبالغ
            $table->decimal('rent_value', 10, 2)->default(0);
            $table->decimal('water_value', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            // التحصيل
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('status')->default('unpaid'); // unpaid|partial|paid
            $table->date('deposit_date')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            // مفيد للاستعلامات
            $table->index(['contract_id', 'due_date']);
            $table->index(['contract_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_payments');
    }
};
