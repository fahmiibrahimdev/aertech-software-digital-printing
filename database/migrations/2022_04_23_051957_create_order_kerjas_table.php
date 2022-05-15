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
        Schema::create('order_kerjas', function (Blueprint $table) {
            $table->text('id');
            $table->text('id_customer');
            $table->text('nomor_transaksi');
            $table->text('tanggal');
            $table->text('deadline');
            $table->text('deadline_time');
            $table->text('total');
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
        Schema::dropIfExists('order_kerjas');
    }
};
