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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sales_order_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->text('desc')->nullable();
            $table->foreignId('customer_id')->constrained();
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->char('approval_status', '1')->default('0')->comment('0=tunggu | 1=setuju | 2=tolak');
            $table->date('approval_date')->nullable();
            $table->text('approval_desc')->nullable();

            $table->integer('lead_time')->default('0');
            $table->char('ppn_type', '1')->comment('1=tanpa ppn | 2=include | 3=exclude');
            $table->char('is_locked', '1')->default('0')->comment('0=buka | 1=tutup');
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->decimal('total_amount', 11, 2)->default('0');
            $table->char('payment_type', '1')->nullable()->comment('1=cash | 2=kredit');
            $table->integer('term')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
