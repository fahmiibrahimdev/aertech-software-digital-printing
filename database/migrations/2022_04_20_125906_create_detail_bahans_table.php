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
        Schema::create('detail_bahans', function (Blueprint $table) {
            $table->id();
            $table->text('id_level_customer');
            $table->text('id_pekerjaan');
            $table->text('id_bahan');
            $table->text('ukuran');
            $table->text('min_qty')->default('1');
            $table->text('max_qty')->default('1');
            $table->text('harga_jual');
            $table->text('min_order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_bahans');
    }
};
