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
        Schema::create('sales_invoice_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_invoice_id')->constrained();
            $table->text('cost_desc')->nullable();
            $table->decimal('qty', 11, 4)->default(0);
            $table->decimal('price', 11, 2)->default(0);
            $table->decimal('ppn', 11, 2)->default(0);
            $table->decimal('dpp', 11, 2)->default(0);
            $table->decimal('total', 11, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoice_costs');
    }
};
