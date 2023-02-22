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
            $table->char('id', 15)->primary();
            // Anggota Tim
            $table->char('jawaban_at', 6)->nullable();
            $table->text('catatan_at')->nullable();
            $table->double('nilai_at', 6, 2)->nullable();
            // Ketua tim
            $table->char('jawaban_kt', 6)->nullable();
            $table->text('catatan_kt')->nullable();
            $table->double('nilai_kt', 6, 2)->nullable();
            // Pengendali Teknis
            $table->char('jawaban_pt', 6)->nullable();
            $table->text('catatan_pt')->nullable();
            $table->double('nilai_pt', 6, 2)->nullable();
            $table->char('pengawasan_id');
            $table->timestamps();
            $table->foreign('id')->references('id')->on('self_assessment')->onDelete('cascade');
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
