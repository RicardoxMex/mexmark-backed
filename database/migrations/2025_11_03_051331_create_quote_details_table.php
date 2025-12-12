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
        Schema::create('quote_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');
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

            $table->index(['quote_id', 'line_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_details');
    }
};
