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
        Schema::create('hotel_room_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_record_id')->constrained('agent_records')->onDelete('cascade');
            $table->string('room_type')->comment('e.g., Standard, Deluxe, Suite');
            $table->integer('capacity')->default(2)->comment('Guest capacity');
            $table->integer('available_rooms')->default(5);
            $table->decimal('price_per_night', 10, 2);
            $table->text('room_description')->nullable();
            $table->json('amenities')->nullable()->comment('Room amenities array');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['agent_record_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_room_options');
    }
};
