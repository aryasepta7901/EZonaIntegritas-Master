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
            $table->id();
            $table->char('rekapitulasi_id', 12); // one to one rekapitulasi_id
            $table->text('surat_pengantar_kabkota')->nullable();
            $table->text('surat_pengantar_prov')->nullable();
            $table->text('LHE_1')->nullable(); //tahap 1
            $table->text('LHE_2')->nullable(); //tahap 2
            $table->timestamps();
            $table->foreign('rekapitulasi_id')->references('id')->on('rekapitulasi')->onDelete('cascade');
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
