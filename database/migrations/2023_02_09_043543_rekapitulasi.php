<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rekapitulasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekapitulasi', function (Blueprint $table) {

            $table->char('id', 12)->primary(); //tahun.predikat.satker_id
            $table->year('tahun');
            $table->char('predikat', 4);
            $table->char('status', 1)->default(0);
            $table->integer('satker_id'); //4

            $table->timestamps();
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
        Schema::dropIfExists('rekapitulasi');
    }
}
