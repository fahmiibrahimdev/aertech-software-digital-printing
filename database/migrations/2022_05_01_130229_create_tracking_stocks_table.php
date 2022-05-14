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
        Schema::create('tracking_stocks', function (Blueprint $table) {
            $table->id();
            $table->text('id_detail_order_kerja');
            $table->text('id_bahan');
            $table->text('date');
            $table->text('qty');
            $table->text('keterangan');
            $table->enum('category', ['In','Out']);
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
        Schema::dropIfExists('tracking_stocks');
    }
};
