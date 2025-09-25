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
        Schema::create('stock_usages', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('stock_usage_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->string('type_transaction')->comment('penjualan | kerugian lain');
            $table->foreignId('user_id')->constrained();
            $table->char('status', 1)->default('1');
            $table->unsignedBigInteger('void_user_id')->nullable();
            $table->foreign('void_user_id')->references('id')->on('users');
            $table->char('void_status', '1')->default(0)->comment('0=aktif | 1=batal');
            $table->date('void_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_usages');
    }
};
