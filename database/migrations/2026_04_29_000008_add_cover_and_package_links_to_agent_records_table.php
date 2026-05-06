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
        Schema::table('agent_records', function (Blueprint $table) {
            $table->string('cover_image')->nullable()->after('reference_code');
            $table->foreignId('flight_record_id')
                ->nullable()
                ->after('cover_image')
                ->constrained('agent_records')
                ->nullOnDelete();
            $table->foreignId('hotel_record_id')
                ->nullable()
                ->after('flight_record_id')
                ->constrained('agent_records')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agent_records', function (Blueprint $table) {
            $table->dropConstrainedForeignId('flight_record_id');
            $table->dropConstrainedForeignId('hotel_record_id');
            $table->dropColumn('cover_image');
        });
    }
};
