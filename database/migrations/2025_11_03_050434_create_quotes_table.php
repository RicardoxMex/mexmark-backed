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
         Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quote_num');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->enum('status',['pending','approved', 'rejected', 'expired'])->default('pending');
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 4)->default(0);
            $table->decimal('subtotal_amount', 15, 4)->default(0);
            $table->decimal('total_amount', 15, 4)->default(0);
            $table->unsignedInteger('validity_days')->default(3);
            $table->date('issue_date');
            $table->date('due_date');
            $table->text('terms')->nullable();
            $table->text('payment_terms')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
