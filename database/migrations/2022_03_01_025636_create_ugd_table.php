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
        Schema::create('ugd', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('no_rm')->nullable();
            $table->string('nama_pasien');
            $table->string('kewarganegaraan');
            $table->string('nik')->nullable();
            $table->string('no_passport')->nullable();
            $table->boolean('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->string('telepon');
            $table->string('nowa');
            $table->string('status');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->integer('kode_pos');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('suami_istri')->nullable();
            $table->string('asuransi')->nullable();
            $table->string('no_asuransi')->nullable();

            $table->string('nama_pas_td')->nullable();
            $table->string('perkiraan_umur');
            $table->string('lokasi_temu');
            $table->date('tgl_temu');

            $table->string('nama_penanggungjawab');
            $table->string('alamat_penanggungjawab');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rw');
            $table->string('rt');
            $table->integer('kode_pos');
            $table->string('negara');
            $table->string('tlp_pen_jaw');
            $table->string('hubungan_dgn_pasien');

            $table->string('nama_pengantar');
            $table->string('alamat_pengantar');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rw');
            $table->string('rt');
            $table->integer('kode_pos');
            $table->string('negara');
            $table->string('tlp_pengantar');

            $table->string('nama_bayi');
            $table->string('nik_ibu_kandung');
            $table->string('no_rm');
            $table->date('tgl_lahir_bayi');
            $table->string('jam_lahir_bayi');
            $table->string('jk_bayi');

            $table->timestamps();
            $table->softDeletes();

            $table->index('nama_pasien');
            $table->unique(['nik', 'no_passport']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugd');
    }
};
