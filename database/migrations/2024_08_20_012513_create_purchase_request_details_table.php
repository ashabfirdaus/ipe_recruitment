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
        Schema::create('purchase_request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_request_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('qty', 11, 4)->default(0);
            $table->text('desc')->nullable();
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->date('approval_date')->nullable();
            $table->char('approval_status', '1')->default('0')->comment('0=tunggu | 1=setuju | 2=tolak');
            $table->char('status', '1')->default('0')->comment('1=tutup | 0=buka');
            $table->text('approval_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_details');
    }
};
