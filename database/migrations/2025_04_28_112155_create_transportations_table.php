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
        Schema::create('transportations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preparation_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('departure_location');
            $table->string('arrival_location');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->decimal('price', 10, 2);
            $table->enum('trip_type', ['personal', 'with_friends', 'open_trip'])->default('personal');
            $table->enum('status', ['available', 'not_available', 'cancelled', 'booked'])->nullable()->default('available');
            $table->text('notes')->nullable();
            $table->boolean('checked')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};
