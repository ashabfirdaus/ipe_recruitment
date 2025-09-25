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
        Schema::create('item_account_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('sub_category_id')->constrained();
            $table->foreignId('item_type_id')->nullable()->constrained();
            $table->integer('tax_coa_id')->unsigned()->nullable();
            $table->foreign('tax_coa_id')->references('id')->on('master_coas');
            $table->integer('inventory_coa_id')->unsigned()->nullable();
            $table->foreign('inventory_coa_id')->references('id')->on('master_coas');
            $table->integer('expense_coa_id')->unsigned()->nullable();
            $table->foreign('expense_coa_id')->references('id')->on('master_coas');
            $table->char('status', '1')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_account_settings');
    }
};
