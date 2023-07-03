<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**A
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('no_telp', 14);
            $table->integer('satker_id');
            $table->char('level_id', 2);
            $table->rememberToken();
            $table->timestamps();
            // $table->foreign('level_id')->references('id')->on('level')->onDelete('cascade');
            // $table->foreign('satker_id')->references('id')->on('satker')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
