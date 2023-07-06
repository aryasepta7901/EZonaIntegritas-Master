<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubPilar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpilar', function (Blueprint $table) {
            $table->char('id', 4)->primary();
            $table->string('subPilar');
            $table->double('bobot', 6, 2);
            $table->char('pilar_id', 3);
            $table->timestamps();

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
        Schema::dropIfExists('subpilar');
    }
}
