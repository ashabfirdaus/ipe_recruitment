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
        Schema::create('stock_repacks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('stock_repack_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->char('status', 1)->default('1');
            $table->foreignId('bom_id')->constrained();
            $table->decimal('multiple_qty', 11, 4)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_repacks');
    }
};
