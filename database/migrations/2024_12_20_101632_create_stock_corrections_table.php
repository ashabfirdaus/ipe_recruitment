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
        Schema::create('stock_corrections', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('stock_correction_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->char('status', 1)->default('1');
            $table->unsignedBigInteger('void_user_id')->nullable();
            $table->foreign('void_user_id')->references('id')->on('users');
            $table->char('void_status', '1')->default(0);
            $table->date('void_date')->nullable();
            $table->text('void_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_corrections');
    }
};
