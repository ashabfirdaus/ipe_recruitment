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
        Schema::create('stock_correction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_correction_id')->constrained();
            $table->string('qrcode');
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('qty', 11, 4)->default(0);
            $table->text('desc')->nullable();
            $table->date('expired_date')->nullable();
            $table->char('detail_status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->char('correction_type', 3)->default('in')->comment('in,out');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_correction_details');
    }
};
