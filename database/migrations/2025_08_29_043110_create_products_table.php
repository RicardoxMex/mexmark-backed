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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('base_price', 10, 2)->nullable();
            $table->enum('availability', ['in_stock', 'on_demand'])->default('in_stock');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('has_variants')->default(false);
            $table->string('image')->nullable();
            $table->foreignId('subcategory_id')->constrained('sub_categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->foreignId('attribute_group_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
