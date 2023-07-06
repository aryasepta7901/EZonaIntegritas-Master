<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Opsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opsi', function (Blueprint $table) {
            $table->char('id', 6)->primary();
            $table->string('rincian');
            $table->double('bobot', 6, 2);
            $table->string('type', 100);
            $table->char('pertanyaan_id', 5);

            $table->timestamps();

            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('opsi');
    }
}
