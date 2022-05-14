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
        Schema::create('tracking_users', function (Blueprint $table) {
            $table->id();
            $table->text('id_detail_order_kerja');
            $table->text('id_user_produksi');
			$table->timestamp('tanggal_finishing')->nullable();
            $table->text('id_user_finishing');
			$table->timestamp('tanggal_taking')->nullable();
            $table->text('id_user_taking');
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
        Schema::dropIfExists('tracking_users');
    }
};
