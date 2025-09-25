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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name');
            $table->string('supplier_code')->nullable();
            $table->text('supplier_address')->nullable();
            $table->char('status', '1')->default('1')->comment('1=aktif | 0=tidak_aktif');
            $table->string('phone')->nullable();
            $table->char('term_of_payment', 1)->comment('1=cash | 2=credit');
            $table->integer('term_of_payment_days')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_contact')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
