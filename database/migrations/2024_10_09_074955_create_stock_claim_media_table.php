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
        Schema::create('stock_claim_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_claim_id')->constrained();
            $table->foreignId('stock_claim_detail_id')->nullable()->constrained();
            $table->foreignId('media_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_claim_media');
    }
};
