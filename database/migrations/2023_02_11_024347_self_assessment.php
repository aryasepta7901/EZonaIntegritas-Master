<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SelfAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_assessment', function (Blueprint $table) {
            $table->char('id', 15)->primary(); //tahun.satker_id.pertanyaan_id
            $table->year('tahun');
            $table->char('opsi_id', 6);
            $table->text('catatan');
            $table->double('nilai', 6, 2);
            $table->char('rekapitulasi_id', 36);
            $table->integer('satker_id'); // 4
            $table->char('pertanyaan_id', 5);
            $table->timestamps();
            $table->foreign('rekapitulasi_id')->references('id')->on('rekapitulasi')->onDelete('cascade');
            $table->foreign('satker_id')->references('id')->on('satker')->onDelete('cascade');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('cascade');
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
        Schema::dropIfExists('self_assessment');
    }
}
