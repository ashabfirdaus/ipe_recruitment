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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('item_code')->nullable();
            $table->foreignId('sub_category_id')->constrained();
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->char('is_stock', '1')->default('1')->comment('1=barang_stok | 0=barang_bukan_stok');
            $table->foreignId('unit_measure_id')->constrained();
            $table->string('item_barcode')->nullable();
            $table->string('barcode')->nullable();
            $table->foreignId('item_type_id')->nullable()->constrained();
            $table->foreignId('category_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
