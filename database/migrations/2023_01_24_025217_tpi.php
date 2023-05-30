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
            $table->string('id', 12)->primary(); //nama.tahun.wilayah
            $table->year('tahun');
            $table->string('nama');
            $table->bigInteger('dalnis', 15);
            $table->bigInteger('ketua_tim', 15);
            $table->timestamps();

            $table->char('wilayah', 1);
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
