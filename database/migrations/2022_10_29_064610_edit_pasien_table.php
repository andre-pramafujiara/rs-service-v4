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
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('suku')->nullable();
            $table->string('bahasa')->nullable();
            $table->string('alamat_ktp')->nullable();
            $table->string('rt_ktp')->nullable();
            $table->string('rw_ktp')->nullable();
            $table->string('kelurahan_ktp')->nullable();
            $table->string('kecamatan_ktp')->nullable();
            $table->string('kabupaten_ktp')->nullable();
            $table->integer('kode_pos_ktp')->nullable();
            $table->string('provinsi_ktp')->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->string('rt_domisili')->nullable();
            $table->string('rw_domisili')->nullable();
            $table->string('kelurahan_domisili')->nullable();
            $table->string('kecamatan_domisili')->nullable();
            $table->string('kabupaten_domisili')->nullable();
            $table->integer('kode_pos_domisili')->nullable();
            $table->string('provinsi_domisili')->nullable();
            $table->string('negara_domisili')->nullable();

            $table->dropColumn('alamat');
            $table->dropColumn('rt');
            $table->dropColumn('rw');
            $table->dropColumn('kelurahan');
            $table->dropColumn('kecamatan');
            $table->dropColumn('kabupaten');
            $table->dropColumn('provinsi');
            $table->dropColumn('kode_pos');
            $table->dropColumn('nama_ayah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('suku')->nullable();
            $table->dropColumn('bahasa')->nullable();
            $table->dropColumn('alamat_ktp');
            $table->dropColumn('rt_ktp');
            $table->dropColumn('rw_ktp');
            $table->dropColumn('kelurahan_ktp');
            $table->dropColumn('kecamatan_ktp');
            $table->dropColumn('kabupaten_ktp');
            $table->dropColumn('kode_pos_ktp');
            $table->dropColumn('provinsi_ktp');
            $table->dropColumn('alamat_domisili')->nullable();
            $table->dropColumn('rt_domisili')->nullable();
            $table->dropColumn('rw_domisili')->nullable();
            $table->dropColumn('kelurahan_domisili')->nullable();
            $table->dropColumn('kecamatan_domisili')->nullable();
            $table->dropColumn('kabupaten_domisili')->nullable();
            $table->dropColumn('kode_pos_domisili')->nullable();
            $table->dropColumn('provinsi_domisili')->nullable();
            $table->dropColumn('negara_domisili')->nullable();

            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->integer('kode_pos');
            $table->string('nama_ayah');
        });
    }
};
