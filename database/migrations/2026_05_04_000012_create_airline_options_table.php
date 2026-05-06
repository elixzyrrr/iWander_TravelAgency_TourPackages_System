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
        Schema::create('airline_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_record_id')->constrained('agent_records')->cascadeOnDelete();
            $table->string('airline_name');
            $table->string('airline_code', 20)->nullable();
            $table->string('icon', 50)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->json('flights');
            $table->timestamps();

            $table->index(['agent_record_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_options');
    }
};