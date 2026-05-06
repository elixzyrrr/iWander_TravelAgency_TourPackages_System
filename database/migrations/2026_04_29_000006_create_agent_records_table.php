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
        Schema::create('agent_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('module')->index();
            $table->string('reference_code')->nullable()->index();
            $table->string('title');
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('destination')->nullable();
            $table->string('travel_type')->nullable();
            $table->date('travel_start')->nullable();
            $table->date('travel_end')->nullable();
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('status')->default('pending')->index();
            $table->text('description')->nullable();
            $table->json('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_records');
    }
};
