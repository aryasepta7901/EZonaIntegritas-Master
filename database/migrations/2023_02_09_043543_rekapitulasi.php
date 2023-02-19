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

            $table->char('id', 15)->primary();
            $table->year('tahun');
            $table->char('predikat', 4);
            $table->double('nilai_pengungkit', 6, 2)->default(0);
            $table->double('nilai_hasil', 6, 2)->default(0);
            $table->char('status', 1)->default(0);
            $table->char('satker_id', 4);
            $table->text('surat_rekomendasi');
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
