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
        Schema::create('split_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('split_stock_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->char('status', 1)->default('1');
            $table->unsignedBigInteger('void_user_id')->nullable();
            $table->foreign('void_user_id')->references('id')->on('users');
            $table->date('void_date')->nullable();
            $table->string('old_qrcode');
            $table->decimal('old_qty', 11, 4)->default(0);
            $table->foreignId('item_stock_id')->constrained();
            $table->string('split_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('split_stocks');
    }
};
