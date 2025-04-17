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
        Schema::create('gears', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->foreignId('type_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->foreignId('category_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->string('brand');
            $table->string('slug')->unique();
            $table->string('price')->nullable();
            $table->string('link_product')->nullable();
            $table->foreignId('status_id')
                    ->constrained()
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gears');
    }
};
