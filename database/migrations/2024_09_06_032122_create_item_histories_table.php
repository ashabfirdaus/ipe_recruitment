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
        Schema::create('item_histories', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->string('transaction_type')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('qrcode')->nullable();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('stock_in', 11, 4)->default(0);
            $table->decimal('stock_out', 11, 4)->default(0);
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->decimal('hpp', 11, 2)->default(0);
            $table->char('status', '1')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_histories');
    }
};
