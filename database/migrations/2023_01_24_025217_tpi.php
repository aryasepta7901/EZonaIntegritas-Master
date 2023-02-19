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
            $table->string('id', 12)->primary();
            $table->year('tahun');
            $table->string('nama');
            $table->string('dalnis');
            $table->string('ketua_tim');
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
