<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rekaphasil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekaphasil', function (Blueprint $table) {
            $table->increments('id');
            $table->year('tahun');
            $table->char('opsi_id', 4);
            $table->double('nilai', 6, 2);
            $table->char('pilar_id', 3);
            $table->integer('satker_id'); //4

            $table->timestamps();
            $table->foreign('satker_id')->references('id')->on('satker')->onDelete('cascade');
            $table->foreign('pilar_id')->references('id')->on('pilar')->onDelete('cascade');
            $table->foreign('opsi_id')->references('id')->on('opsi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekaphasil');
    }
}
