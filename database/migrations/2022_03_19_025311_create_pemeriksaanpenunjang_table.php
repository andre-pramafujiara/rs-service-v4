<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemeriksaanpenunjang', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nomor_rekam_medis');
            $table->string('nama_pasien');
            $table->string('nik');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->time('jam');
            $table->date('tanggal');
            $table->string('laboratorium');
            $table->string('radiologi');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('laboratorium')->references('id')->on('laboratorium');
            $table->foreign('radiologi')->references('id')->on('radiologi');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pemeriksaanpenunjang');
    }
};
