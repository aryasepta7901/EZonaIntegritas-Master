<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LHE extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LHE', function (Blueprint $table) {
            $table->char('id', 12)->primary(); // one to one rekapitulasi_id
            $table->text('surat_pengantar_kabkota');
            $table->text('surat_pengantar_prov');
            $table->text('LHE_1'); //tahap 1
            $table->text('LHE_2'); //tahap 2
            $table->timestamps();
            $table->foreign('id')->references('id')->on('rekapitulasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LHE');
    }
}
