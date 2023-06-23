<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeskEvaluation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desk_evaluation', function (Blueprint $table) {
            $table->char('id', 15)->primary(); // one to one id_selfassessment
            $table->char('rekapitulasi_id', 12);

            // Anggota Tim
            $table->char('jawaban_at', 6)->nullable();
            $table->text('catatan_at')->nullable();
            $table->double('nilai_at', 6, 2)->nullable();
            // Ketua tim
            $table->char('jawaban_kt', 6)->nullable();
            $table->text('catatan_kt')->nullable();
            $table->double('nilai_kt', 6, 2)->nullable();
            // Pengendali Teknis
            $table->char('jawaban_dl', 6)->nullable();
            $table->text('catatan_dl')->nullable();
            $table->double('nilai_dl', 6, 2)->nullable();
            $table->bigInteger('pengawasan_id');
            $table->foreign('rekapitulasi_id')->references('id')->on('rekapitulasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desk_evaluation');
    }
}
