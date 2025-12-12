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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_payment_gateways_table.php
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('provider'); // stripe, paypal, etc.
            $table->enum('type', ['online', 'offline', 'cash', 'card'])->default('online');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_sandbox')->default(true);
            $table->json('supported_currencies')->nullable();
            $table->decimal('fee_percentage', 5, 2)->nullable();
            $table->decimal('fee_fixed', 10, 2)->nullable();

            // Configuración del proveedor
            $table->text('api_key')->nullable();
            $table->text('secret_key')->nullable();
            $table->text('webhook_url')->nullable();
            $table->string('merchant_id')->nullable();
            $table->text('public_key')->nullable();

            // Configuración adicional
            $table->decimal('min_amount', 10, 2)->nullable();
            $table->decimal('max_amount', 10, 2)->nullable();
            $table->json('allowed_countries')->nullable();
            $table->boolean('requires_3ds')->default(false);
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
