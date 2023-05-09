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
        Schema::create('pasien', function (Blueprint $table) {
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
        Schema::dropIfExists('pasien');
    }
};
