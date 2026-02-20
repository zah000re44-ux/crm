<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // قيم التحصيل الأساسية
            $table->decimal('rent_amount', 10, 2)->default(0)->after('ends_at');

            // نوع الدفع: monthly/quarterly/semiannually/annually
            $table->string('payment_type')->default('monthly')->after('rent_amount');

            // الماء خيارين: يا قيمة ثابتة لكل شهر، أو صفر إذا ما تستخدمه
            $table->decimal('water_amount', 10, 2)->default(0)->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['rent_amount', 'payment_type', 'water_amount']);
        });
    }
};
