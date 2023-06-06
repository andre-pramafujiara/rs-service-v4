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
        Schema::create('pasienb', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_pas_td')->nullable();
            $table->string('perkiraan_umur');
            $table->string('lokasi_temu');
            $table->date('tgl_temu');
            $table->string('penjaw_id')->nullable();
            $table->string('peng_id')->nullable();
            $table->string('bbl_id')->nullable();
            $table->timestamps();

            $table->foreign('penjaw_id')->references('id')->on('penanggungjawab');
            $table->foreign('peng_id')->references('id')->on('pagantar');
            $table->foreign('bbl_id')->references('id')->on('bbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasienb');
    }
};
