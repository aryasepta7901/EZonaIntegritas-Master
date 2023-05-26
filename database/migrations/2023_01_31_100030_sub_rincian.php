<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubRincian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subRincian', function (Blueprint $table) {
            $table->char('id', 2)->primary();
            $table->string('subRincian');
            $table->double('bobot', 6, 2);
            $table->char('rincian_id', 1);
            $table->timestamps();

            $table->foreign('rincian_id')->references('id')->on('rincian')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subRincian');
    }
}
