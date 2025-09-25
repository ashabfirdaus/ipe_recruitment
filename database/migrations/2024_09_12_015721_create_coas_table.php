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
        Schema::create('coas', function (Blueprint $table) {
            $table->id();
            $table->char('account_type', 1)->comment('N=neraca | LR=labarugi');
            $table->string('account_code');
            $table->string('account_name');
            $table->integer('parent_id')->nullable();
            $table->char('status', '1')->default('1')->comment('1=aktif|0=tidak aktif');
            $table->text('desc')->nullable();
            $table->string('header1')->nullable();
            $table->string('header2')->nullable();
            $table->string('header3')->nullable();
            $table->string('lr_header1')->nullable();
            $table->string('lr_header2')->nullable();
            $table->string('lr_header3')->nullable();
            $table->char('position', '1')->nullable()->comment('D=debet | K=kredit');
            $table->integer('level')->nullable();
            $table->char('is_transaction', 1)->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coas');
    }
};
