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
        Schema::create('anamnesis', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('keluhan_utama');
            $table->string('riwayat_penyakit');
            $table->string('riwayat_alergi');
            $table->string('riwayat_pengobatan');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('riwayat_penyakit')->references('id')->on('riwayatpenyakit');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anamnesis');
    }
};
