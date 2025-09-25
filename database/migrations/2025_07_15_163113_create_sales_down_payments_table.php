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
        Schema::create('sales_down_payments', function (Blueprint $table) {
            $table->id();
            $table->string('sales_down_payment_code');
            $table->foreignId('branch_id')->constrained();
            $table->date('date');
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('sales_order_id')->constrained();
            $table->foreignId('currency_id')->constrained();
            $table->decimal('rate', 11, 2)->default(0);
            $table->decimal('nominal', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->text('desc')->nullable();
            $table->char('status', 1)->default(1);
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_down_payments');
    }
};
