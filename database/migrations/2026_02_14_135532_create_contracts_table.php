<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();

            $table->string('contract_no')->nullable()->index();

            $table->enum('type', ['sale', 'rent'])->default('rent');
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft');

            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();

            $table->decimal('amount', 12, 2)->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
