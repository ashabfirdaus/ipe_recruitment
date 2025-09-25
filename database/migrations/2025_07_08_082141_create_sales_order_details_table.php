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
        Schema::create('sales_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_order_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('qty', 11, 4)->default(0);
            $table->text('desc')->nullable();
            $table->decimal('remaining_qty', 11, 4)->default(0);

            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->date('approval_date')->nullable();
            $table->char('approval_status', '1')->default('0')->comment('0=tunggu | 1=setuju | 2=tolak');
            $table->text('approval_desc')->nullable();

            $table->char('status', '1')->default('0')->comment('1=tutup | 0=buka');
            // $table->foreignId('purchase_request_detail_id')->constrained();
            $table->decimal('price', 11, 2)->default(0);
            $table->decimal('discount', 11, 2)->default(0);
            $table->decimal('ppn', 11, 2)->default(0);
            $table->decimal('dpp', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->char('detail_status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_order_details');
    }
};
