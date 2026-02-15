<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client_notes', function (Blueprint $table) {
            if (!Schema::hasColumn('client_notes', 'type')) {
                $table->string('type')->default('note')->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('client_notes', function (Blueprint $table) {
            if (Schema::hasColumn('client_notes', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
