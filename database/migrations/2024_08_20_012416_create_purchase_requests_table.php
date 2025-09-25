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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_request_code');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('warehouse_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->date('date');
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->unsignedBigInteger('approval_user_id')->nullable();
            $table->foreign('approval_user_id')->references('id')->on('users');
            $table->date('approval_date')->nullable();
            $table->char('is_locked', '1')->default('1')->comment('1=terbuka | 2=tertutup');
            $table->text('desc')->nullable();
            $table->char('approval_status', '1')->default('0')->comment('0=menunggu | 1=setuju | 2=tolak');
            $table->text('approval_desc')->nullable();
            $table->date('estimation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
