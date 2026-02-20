<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {

            // إذا العمود موجود لا تعيد إضافته
            if (!Schema::hasColumn('contracts', 'unit_id')) {
                $table->foreignId('unit_id')
                      ->after('client_id')
                      ->constrained()
                      ->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {

            if (Schema::hasColumn('contracts', 'unit_id')) {
                // dropForeign قد يفشل إذا ما فيه FK فعليًا، لذلك نتحقق بطريقة آمنة
                try {
                    $table->dropForeign(['unit_id']);
                } catch (\Throwable $e) {
                    // تجاهل إذا ما فيه FK
                }

                $table->dropColumn('unit_id');
            }
        });
    }
};
