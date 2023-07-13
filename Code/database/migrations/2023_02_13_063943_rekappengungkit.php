<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RekapPengungkit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekappengungkit', function (Blueprint $table) {
            // $table->char('id', 15)->primary(); //pilar_id.rekapitulasi_id
            $table->increments('id');
            $table->double('nilai_sa', 6, 3);
            $table->double('nilai_at', 6, 3)->nullable();
            $table->double('nilai_kt', 6, 3)->nullable();
            $table->double('nilai_dl', 6, 3)->nullable();
            $table->char('rekapitulasi_id', 36);
            $table->char('pilar_id', 3);
            $table->timestamps();
            $table->foreign('rekapitulasi_id')->references('id')->on('rekapitulasi')->onDelete('cascade');
            $table->foreign('pilar_id')->references('id')->on('pilar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekappengungkit');
    }
}
