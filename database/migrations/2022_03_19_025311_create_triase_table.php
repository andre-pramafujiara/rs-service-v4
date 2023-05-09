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
        Schema::create('triase', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('id_pasien')->nullable();
            $table->string('id_perawat')->nullable();
            $table->string('nama_petugas');
            $table->date('tanggal_triase');
            $table->time('jam_triase');
            $table->string('triase_esi');
            $table->string('respon_time');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pasien')->references('id')->on('pasien');
            // $table->foreign('id_perawat')->references('id')->on('perawat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('triase');
    }
};
