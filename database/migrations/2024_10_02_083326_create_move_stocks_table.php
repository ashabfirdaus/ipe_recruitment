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
        Schema::create('move_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('move_stock_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->text('desc')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->char('status', 1)->default('2')->comment('2=dalam_perjalanan | 1=diterima');
            $table->unsignedBigInteger('branch2_id')->nullable();
            $table->foreign('branch2_id')->references('id')->on('branches');
            $table->unsignedBigInteger('warehouse2_id')->nullable();
            $table->foreign('warehouse2_id')->references('id')->on('warehouses');
            $table->char('transaction_type', '1')->comment('1=kirim | 2=terima');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->foreign('reference_id')->references('id')->on('warehouses');
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->char('approval_status', '1')->default(0);
            $table->date('approval_date')->nullable();
            $table->text('approval_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('move_stocks');
    }
};
