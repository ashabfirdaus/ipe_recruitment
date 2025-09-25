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
        Schema::create('sales_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('unit_measure_id')->constrained();
            $table->decimal('qty', 11, 4)->default(0);
            $table->text('desc')->nullable();
            $table->decimal('price', 11, 2)->default(0);
            $table->decimal('discount', 11, 2)->default(0);
            $table->decimal('ppn', 11, 2)->default(0);
            $table->decimal('dpp', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->char('detail_status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_details');
    }
};
