<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnggotaTpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_tpi', function (Blueprint $table) {

<<<<<<< HEAD
            $table->bigInteger('id')->primary(); //tpi_id.tahun
            $table->char('tpi_id', 12);
            $table->bigInteger('anggota_id');
            $table->timestamps();

            $table->foreign('tpi_id')->references('id')->on('TPI')->onDelete('cascade');
=======
            $table->increments('id');
            $table->char('tpi_id', 12);
            $table->unsignedBigInteger('anggota_id');
            $table->timestamps();

            $table->foreign('tpi_id')->references('id')->on('TPI')->onDelete('cascade');
            $table->foreign('anggota_id')->references('id')->on('users')->onDelete('cascade');
>>>>>>> 1eb266e (update)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggota_tpi');
    }
}
