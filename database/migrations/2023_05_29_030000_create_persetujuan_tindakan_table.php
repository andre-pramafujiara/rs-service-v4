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
        Schema::create('persetujuan_tindakan', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_pasien');
            $table->string('nama_dokter');
            $table->string('nama_petugas');
            $table->string('nama_keluarga_pasien');
            $table->date('tindakan_yang_dilakukan');
            $table->string('konsekuensi_tindakan');
            $table->string('persetujuan_atau_penolokan');
            $table->string('tangga_pemberian');
            $table->time('jam_pemberian');
            $table->string('membuat_pernyataan');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('membuatpernyataan')->references('id')->on('membuatpernyataan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persetujuan_tindakan');
    }
};
