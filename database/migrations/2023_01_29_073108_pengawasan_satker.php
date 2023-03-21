<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengawasanSatker extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengawasan_satker', function (Blueprint $table) {
            $table->id()->unique(); //anggota_id.satker_id
            $table->integer('satker_id', 4);
            $table->char('tpi_id', 15);
            $table->bigInteger('anggota_id', 15);
            $table->char('status', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengawasan_satker');
    }
}
