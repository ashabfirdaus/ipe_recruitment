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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->string('sub_category_name');
            $table->string('sub_category_code')->nullable();
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->char('use_expired', '1')->default('1')->comment('1 = pakai expired | 0 = tanpa expired');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
