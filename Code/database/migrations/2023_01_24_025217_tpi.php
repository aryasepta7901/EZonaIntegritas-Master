<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tpi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TPI', function (Blueprint $table) {
<<<<<<< HEAD
            $table->char('id', 12)->primary(); //nama.tahun.wilayah
            $table->year('tahun');
            $table->string('nama');
            $table->bigInteger('dalnis'); //15
            $table->bigInteger('ketua_tim'); //15
=======
            $table->char('id', 12)->primary();
            $table->year('tahun');
            $table->string('nama');
            $table->unsignedBigInteger('dalnis'); //15
            $table->unsignedBigInteger('ketua_tim'); //15
>>>>>>> 1eb266e (update)
            $table->char('wilayah', 1);
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
        Schema::dropIfExists('TPI');
    }
}
