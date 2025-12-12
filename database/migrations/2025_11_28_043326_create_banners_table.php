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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();

            // Contenido del banner
            $table->string('title');
            $table->text('subtitle')->nullable();
            
            // Tipo de fondo
            $table->enum('background_type', ['gradient', 'image'])->default('image');
            
            // Configuración de gradiente
            $table->string('gradient_from')->nullable();
            $table->string('gradient_via')->nullable();
            $table->string('gradient_to')->nullable();
            $table->string('gradient_direction')->default('to-br');

            // Configuración de imagen
            $table->string('image')->nullable();
            $table->string('product_image')->nullable(); // Imagen adicional de producto
            $table->string('image_overlay')->nullable();
            $table->integer('image_overlay_opacity')->default(50);

            // Call to Action
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();

            // Configuración
            $table->integer('display_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
