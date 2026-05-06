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
        Schema::table('user_dashboard_bookings', function (Blueprint $table) {
            $table->foreignId('agent_record_id')
                ->nullable()
                ->after('user_dashboard_item_id')
                ->constrained('agent_records')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_dashboard_bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('agent_record_id');
        });
    }
};