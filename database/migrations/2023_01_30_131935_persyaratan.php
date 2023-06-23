<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Persyaratan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persyaratan', function (Blueprint $table) {
            $table->id(); //satker_id.tahun
            $table->year('tahun');
            $table->integer('satker_id'); //4
            $table->boolean('wbk')->default(0);
            $table->boolean('wbbm')->default(0);
            $table->foreign('satker_id')->references('id')->on('satker')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persyaratan');
    }
}
