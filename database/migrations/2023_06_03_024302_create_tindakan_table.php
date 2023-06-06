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
        Schema::create('tindakan', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_tindakan');
            $table->string('petugas_yang_melaksanakan');
            $table->string('tanggal_pelaksanaan');
            $table->time('waktu_mulai_tindakan');
            $table->time('waktu_selesai_tindakan');
            $table->string('alat_medis_yang_digunakan');
            $table->string('BMHP');

            
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tindakan');
    }
};
