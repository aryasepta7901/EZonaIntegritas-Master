<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Rekappilar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekappilar', function (Blueprint $table) {
            $table->char('id', 15)->primary();
            $table->double('nilai', 6, 2);
            $table->char('rekapitulasi_id', 12);
            $table->char('pilar_id', 3);
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
        Schema::dropIfExists('rekappilar');
    }
}
