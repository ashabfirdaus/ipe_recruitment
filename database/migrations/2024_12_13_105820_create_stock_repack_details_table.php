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
        Schema::create('stock_repack_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_repack_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('qty', 11, 4)->default(0);
            $table->string('qrcode')->nullable();
            $table->decimal('hpp', 11, 2)->default(0);
            $table->char('type_data', '1')->comment('1 = material | 2 = result');
            $table->char('status', '1')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_repack_details');
    }
};
