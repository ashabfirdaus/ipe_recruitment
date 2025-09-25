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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('sales_invoice_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->text('desc')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->integer('lead_time')->default('0');
            $table->char('ppn_type', '1')->comment('1=tanpa ppn | 2=include | 3=exclude');
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->decimal('global_ppn', 11, 2)->default('0');
            $table->decimal('global_dpp', 11, 2)->default('0');
            $table->decimal('global_total_price', 11, 2)->default('0');
            $table->char('payment_type', '1')->nullable()->comment('1=cash | 2=kredit');
            $table->integer('term')->default('0');
            $table->foreignId('delivery_order_id')->constrained()->nullable();
            $table->integer('ppn_percentage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};
