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
            $table->id(); //anggota_id.satker_id
            $table->integer('satker_id'); //4
            $table->string('tpi_id', 12);
            $table->bigInteger('anggota_id'); //15
            $table->char('tahap', 1);
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('tpi_id')->references('id')->on('TPI')->onDelete('cascade');
            $table->foreign('satker_id')->references('id')->on('satker')->onDelete('cascade');

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
