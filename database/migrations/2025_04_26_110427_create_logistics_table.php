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
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preparation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('quantity')->nullable()->default(1);
            $table->enum('unit', ['pcs', 'pack', 'box', 'liter', 'ml', 'gram', 'kg'])->default('pcs');
            $table->integer('price')->nullable()->default(0);
            $table->boolean('checked')->default(false);
            $table->text('notes')->nullable();
            $table->boolean('is_group')->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistics');
    }
};
