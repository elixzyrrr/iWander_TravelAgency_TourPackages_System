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
        Schema::create('user_dashboard_sections', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('nav_label')->nullable();
            $table->string('nav_icon')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('section_type')->default('cards');
            $table->longText('body')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_dashboard_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_dashboard_section_id')
                ->constrained('user_dashboard_sections')
                ->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 12)->default('PHP');
            $table->json('meta')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('user_dashboard_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('home_section_key')->nullable();
            $table->unsignedInteger('trips_count')->default(0);
            $table->unsignedInteger('points')->default(0);
            $table->string('preferred_destination')->nullable();
            $table->string('preferred_travel_style')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_dashboard_profiles');
        Schema::dropIfExists('user_dashboard_items');
        Schema::dropIfExists('user_dashboard_sections');
    }
};