<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->text('id_user');
            $table->text('id_order_kerja');
            $table->text('discount_invoice')->default('0');
            $table->text('pembulatan')->default('0');
            $table->text('total_net')->default('0');
            $table->text('bayar_dp')->default('0');
            $table->text('sisa_kurang')->default('0');
            $table->text('metode_pembayaran')->default('CASH');
            $table->text('catatan_produksi')->default('-');
            $table->text('pembayaran')->default('0');
            $table->enum('status_lunas', ['1','0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};
