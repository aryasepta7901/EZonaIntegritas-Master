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
            $table->char('id', 20)->primary(); //opsi_id.selfAssessment_id
            $table->double('input_sa', 6, 2)->nullable();
            $table->double('input_at', 6, 2)->nullable();
            $table->double('input_kt', 6, 2)->nullable();
            $table->double('input_dl', 6, 2)->nullable();
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
