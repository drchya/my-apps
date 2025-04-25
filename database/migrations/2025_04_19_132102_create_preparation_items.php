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
        Schema::create('preparation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preparation_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->json('category_gear');
            $table->enum('status_gear', ['owned', 'rented', 'not_available']);
            $table->enum('urgency', ['urgent', 'important', 'not_urgent']);
            $table->integer('price')->nullable();
            $table->boolean('is_group')->default(false);
            $table->boolean('is_selected')->default(false);
            $table->boolean('is_checked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preparation_items');
    }
};
