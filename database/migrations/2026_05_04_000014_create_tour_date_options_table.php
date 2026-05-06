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
        Schema::create('tour_date_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_record_id')->constrained('agent_records')->onDelete('cascade');
            $table->date('departure_date');
            $table->date('return_date');
            $table->integer('group_size');
            $table->integer('available_slots')->default(10);
            $table->decimal('price_per_person', 10, 2);
            $table->text('tour_description')->nullable();
            $table->json('included_items')->nullable()->comment('What is included in the tour');
            $table->json('excluded_items')->nullable()->comment('What is not included');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['agent_record_id', 'departure_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_date_options');
    }
};
