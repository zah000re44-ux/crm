<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {

            if (!Schema::hasColumn('contracts', 'client_id')) {
                $table->foreignId('client_id')->after('id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('contracts', 'agent_id')) {
                $table->foreignId('agent_id')->after('client_id')->constrained('users')->cascadeOnDelete();
            }

            if (!Schema::hasColumn('contracts', 'contract_no')) {
                $table->string('contract_no')->nullable()->index();
            }

            if (!Schema::hasColumn('contracts', 'type')) {
                $table->enum('type', ['sale', 'rent'])->default('rent');
            }

            if (!Schema::hasColumn('contracts', 'status')) {
                $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');
            }

            if (!Schema::hasColumn('contracts', 'starts_at')) {
                $table->date('starts_at')->nullable();
            }

            if (!Schema::hasColumn('contracts', 'ends_at')) {
                $table->date('ends_at')->nullable();
            }

            if (!Schema::hasColumn('contracts', 'amount')) {
                $table->decimal('amount', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('contracts', 'notes')) {
                $table->text('notes')->nullable();
            }
        });
    }

    public function down(): void
    {
        // ممكن تتركه فاضي أثناء التطوير
    }
};
