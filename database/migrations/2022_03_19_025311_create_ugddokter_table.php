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
        Schema::create('ugddokter', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('triase');
            $table->string('screening');
            $table->string('pemeriksaan_fisik');
            $table->string('assesmen_awal');
            $table->string('instruksi_medis');
            $table->string('rencana_rawat');

            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('triase')->references('id')->on('triase');
            $table->foreign('pemeriksaan_fisik')->references('id')->on('periksafisik');
            $table->foreign('screening')->references('id')->on('screening');
            $table->foreign('assesmen_awal')->references('id')->on('assesmenawaldokterugd');
            $table->foreign('rencana_rawat')->references('id')->on('rencanarawat');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugddokter');
    }
};
