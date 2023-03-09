<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InputField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inputField', function (Blueprint $table) {
            $table->char('id', 20)->primary();
            $table->char('input_sa', 3)->nullable();
            $table->char('input_kt', 3)->nullable();
            $table->char('input_dl', 3)->nullable();
            $table->char('opsi_id', 6);

            $table->char('selfassessment_id', 15);
            $table->timestamps();
            $table->foreign('selfassessment_id')->references('id')->on('self_assessment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inputField');
    }
}
