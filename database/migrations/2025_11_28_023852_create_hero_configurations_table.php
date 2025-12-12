<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_configurations', function (Blueprint $table) {
            $table->id();

            // Badge
            $table->string('badge_text')->nullable();

            // Title
            $table->string('title_main');
            $table->string('title_highlight');

            // Subtitle
            $table->text('subtitle');

            // Primary Button
            $table->string('primary_button_text');
            $table->string('primary_button_url');

            // Secondary Button (optional)
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_url')->nullable();

            // Hero Image (optional)
            $table->string('hero_image_url')->nullable();

            // Stats/Features (optional)
            $table->boolean('show_stats')->default(false);
            $table->string('stat1_value')->nullable();
            $table->string('stat1_label')->nullable();
            $table->string('stat2_value')->nullable();
            $table->string('stat2_label')->nullable();
            $table->string('stat3_value')->nullable();
            $table->string('stat3_label')->nullable();

            // Background Configuration
            $table->enum('background_type', ['gradient', 'image'])->default('gradient');

            // Gradient Settings
            $table->string('gradient_from')->nullable();
            $table->string('gradient_via')->nullable();
            $table->string('gradient_to')->nullable();
            $table->string('gradient_direction')->default('to-br');

            // Background Image Settings
            $table->string('image_url')->nullable();
            $table->enum('image_overlay', ['dark', 'light', 'none'])->nullable();
            $table->integer('image_overlay_opacity')->default(50);

            // Theme
            $table->string('primary_color')->default('blue');
            $table->string('secondary_color')->default('purple');
            $table->enum('text_color', ['light', 'dark'])->default('light');

            // Status
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_configurations');
    }
};
