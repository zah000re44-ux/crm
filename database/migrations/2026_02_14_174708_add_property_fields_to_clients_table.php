<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('building_name')->nullable()->after('name');     // اسم/رقم البناية
            $table->string('district')->nullable()->after('building_name'); // الحي
            $table->string('building_owner')->nullable()->after('district'); // صاحب البناية
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['building_name', 'district', 'building_owner']);
        });
    }
};
