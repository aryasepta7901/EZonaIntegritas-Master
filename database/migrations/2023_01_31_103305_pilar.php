<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pilar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilar', function (Blueprint $table) {
            $table->char('id', 3)->primary();
            $table->string('pilar', 100);
            $table->double('bobot', 6, 2);
            $table->double('min_wbk', 6, 2);
            $table->double('min_wbbm', 6, 2);
            $table->char('subpilar_id', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pilar');
    }
}
