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
        Schema::create('nama_pekerjaans', function (Blueprint $table) {
            $table->id();
            $table->text('id_mesin');
            $table->text('nama_pekerjaan');
            $table->enum('lewat_produksi', [1,0])->default('1');
            $table->enum('lewat_finishing', [1,0])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nama_pekerjaans');
    }
};
