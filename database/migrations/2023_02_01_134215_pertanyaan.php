<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pertanyaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->char('id', 5)->primary();
            $table->string('pertanyaan');
            $table->text('info');
            $table->double('bobot', 6, 2);
            $table->char('subpilar_id', 4);
            $table->timestamps();

            $table->foreign('subpilar_id')->references('id')->on('subpilar')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pertanyaan');
    }
}
