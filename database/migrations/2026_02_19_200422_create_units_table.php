<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
    $table->id();
    $table->foreignId('building_id')->constrained()->cascadeOnDelete();

    $table->string('unit_no'); // رقم/اسم الوحدة
    $table->enum('type', ['apartment','shop','office','villa'])->default('apartment');
    $table->string('floor')->nullable();

    $table->enum('status', ['vacant','rented'])->default('vacant');

    $table->decimal('rent_price', 12, 2)->nullable();
    $table->text('notes')->nullable();

    $table->timestamps();

    $table->unique(['building_id','unit_no']); // نفس الرقم ما يتكرر داخل نفس المبنى
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
