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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_return_code');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('purchase_receipt_id')->constrained();
            $table->date('date');
            $table->text('desc')->nullable();
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('supplier_id')->constrained();
            $table->char('return_type', '1')->comment('1 = retur keseluruhan | 2 = retur tukar barang');
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=batal');
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->char('approval_status', '1')->default('0')->comment('0=tunggu | 1=setuju | 2=tolak');
            $table->date('approval_date')->nullable();
            $table->text('approval_desc')->nullable();
            $table->unsignedBigInteger('void_user_id')->nullable();
            $table->foreign('void_user_id')->references('id')->on('users');
            $table->date('void_date')->nullable();
            $table->char('is_locked', '1')->default('0')->comment('0=buka | 1=tutup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};
