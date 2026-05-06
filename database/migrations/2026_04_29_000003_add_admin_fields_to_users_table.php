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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('agent')->after('email');
            $table->string('status')->default('active')->after('role');
            $table->decimal('commission_rate', 5, 2)->default(0)->after('status');
            $table->decimal('credit_limit', 12, 2)->default(0)->after('commission_rate');
            $table->timestamp('locked_at')->nullable()->after('credit_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'status',
                'commission_rate',
                'credit_limit',
                'locked_at',
            ]);
        });
    }
};
