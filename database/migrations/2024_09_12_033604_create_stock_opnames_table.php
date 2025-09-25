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
        Schema::create('stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('stock_opname_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            // $table->char('status', 1)->default('1')->comment('');
            $table->unsignedBigInteger('void_user_id')->nullable();
            $table->foreign('void_user_id')->references('id')->on('users');
            $table->date('void_date')->nullable();
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('approval_acc_user_id')->nullable();
            $table->foreign('approval_acc_user_id')->references('id')->on('users');
            $table->date('approval_acc_date')->nullable();
            $table->text('approval_desc')->nullable();
            $table->text('approval_acc_desc')->nullable();
            $table->char('approval_status', 1)->default('0');
            $table->char('approval_acc_status', 1)->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_opnames');
    }
};
