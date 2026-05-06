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
        Schema::create('user_dashboard_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_dashboard_section_id')->nullable()->constrained('user_dashboard_sections')->nullOnDelete();
            $table->foreignId('user_dashboard_item_id')->nullable()->constrained('user_dashboard_items')->nullOnDelete();
            $table->string('booking_type');
            $table->string('reference_code')->unique();
            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedSmallInteger('travelers')->default(1);
            $table->unsignedSmallInteger('rooms')->nullable();
            $table->decimal('budget', 12, 2)->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dashboard_bookings');
    }
};