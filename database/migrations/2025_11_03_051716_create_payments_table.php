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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_gateway_id')->constrained()->onDelete('cascade');
            $table->string('payment_reference')->unique(); // Referencia interna
            $table->string('gateway_reference')->nullable(); // Referencia del gateway
            $table->string('status')->default('pending'); // pending, processing, completed, failed, cancelled, refunded
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('MXN');
            $table->string('payment_method'); // card, transfer, cash, etc.

            // Información de la tarjeta (encriptada)
            $table->string('card_last_four')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_expiration')->nullable();

            // Comisiones
            $table->decimal('gateway_fee', 10, 2)->default(0);
            $table->decimal('net_amount', 12, 2);

            // Datos del gateway
            $table->json('gateway_response')->nullable();
            $table->text('gateway_url')->nullable();

            // Reembolsos
            $table->decimal('refunded_amount', 12, 2)->default(0);
            $table->timestamp('refunded_at')->nullable();

            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
