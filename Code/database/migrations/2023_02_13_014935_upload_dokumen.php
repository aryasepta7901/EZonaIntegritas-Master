<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UploadDokumen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_dokumen', function (Blueprint $table) {
            // $table->char('id', 14)->primary();
            $table->increments('id');
            $table->string('file');
            $table->string('name');
            $table->char('dokumenlke_id', 6);
            $table->unsignedInteger('selfassessment_id');
            $table->timestamps();
            $table->foreign('selfassessment_id')->references('id')->on('self_assessment')->onDelete('cascade');
            // $table->foreign('dokumenlke_id')->references('id')->on('dokumenLKE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_dokumen');
    }
}
