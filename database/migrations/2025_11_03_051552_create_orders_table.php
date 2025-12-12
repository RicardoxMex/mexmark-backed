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
        // database/migrations/xxxx_xx_xx_xxxxxx_create_orders_table.php
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('quote_id')->nullable()->constrained()->onDelete('set null');
            $table->string('status')->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded', 'partially_refunded'])->default('pending');

            // Información del cliente (duplicada para histórico)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->string('customer_rfc')->nullable();

            // Direcciones
            $table->text('shipping_address');
            $table->text('billing_address')->nullable();

            // Totales
            $table->decimal('subtotal_amount', 15, 4);
            $table->decimal('discount_amount', 10, 4)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total_amount', 15, 4);

            // Fechas
            $table->date('issue_date');
            $table->date('due_date');

            // Términos
            $table->text('terms')->nullable();
            $table->text('payment_terms')->nullable();

            // Envío
            $table->string('shipping_method')->nullable();
            $table->text('tracking_number')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

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
        Schema::dropIfExists('orders');
    }
};
