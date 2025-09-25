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
        Schema::create('stock_loss_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_loss_id')->constrained();
            $table->foreignId('stock_loss_detail_id')->nullable()->constrained();
            $table->foreignId('media_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_loss_media');
    }
};
