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
        Schema::create('discount_price_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_type_id')->constrained();
            $table->foreignId('sub_categorie_id')->constrained();
            $table->char('data_type', 1)->comment('1 = persen | 2 = nominal');
            $table->decimal('value', 12, 2)->default(0);
            $table->char('status', '1')->default('1');
            $table->char('cal_type', 1)->comment('1 = tambah | 2 = kurang');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_price_types');
    }
};
