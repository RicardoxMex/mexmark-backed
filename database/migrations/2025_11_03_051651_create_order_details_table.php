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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_order_details_table.php
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('quote_detail_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedInteger('line_number');
            $table->string('product_name');
            $table->string('sku');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 15, 4);
            $table->decimal('discount_amount', 10, 4)->default(0);
            $table->decimal('tax_amount', 10, 4)->default(0);
            $table->decimal('total_amount', 15, 4);
            $table->json('attributes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['order_id', 'line_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
