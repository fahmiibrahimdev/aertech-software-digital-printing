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
        Schema::create('detail_order_kerjas', function (Blueprint $table) {
            $table->id();
            $table->text('id_order_kerja');
            $table->text('id_detail_bahan');
            $table->text('nama_file');
            $table->text('ukuran');
            $table->text('qty')->default(0);
            $table->text('harga')->default(0);
            $table->text('laminasi_meter')->default(0);
            $table->text('cutting_meter')->default(0);
            $table->text('laminasi_a3')->default(0);
            $table->text('cutting_a3')->default(0);
            $table->text('discount')->default(0);
            $table->text('keterangan')->default('-');
            $table->text('total')->default(0);
            $table->enum('status', ['1','2','3','4'])->default(1);
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
        Schema::dropIfExists('detail_order_kerjas');
    }
};
