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
            $table->char('id', 15)->primary();
            $table->year('tahun'); //tahun-satker-pilar_id
            $table->char('opsi_id', 6);
            $table->double('nilai', 6, 2);
            $table->char('pilar_id', 3);
            $table->char('satker_id', 4);

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
        Schema::dropIfExists('rekaphasil');
    }
}
