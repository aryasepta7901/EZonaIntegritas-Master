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
            $table->integer('satker_id', 4);
            $table->text('surat_pengantar_prov');
            $table->text('surat_pengantar_kabkota');
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
        Schema::dropIfExists('rekapitulasi');
    }
}
