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
        Schema::create('preparations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('via');
            $table->date('departure_date');
            $table->date('return_date')->nullable();
            $table->enum('type_trip', ['solo_hiking', 'open_trip', 'friends']);
            $table->enum('style_trip', ['hiking', 'camp', 'trail_run']);
            $table->integer('budget_estimate')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preparations');
    }
};
