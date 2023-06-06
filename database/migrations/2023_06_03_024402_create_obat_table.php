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
        Schema::create('obat', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nomor_rekam_medis');
            $table->string('nama_pasien');
            $table->date('tanggal_lahir_pasien');
            $table->integer('tinggi_badan');
            $table->string('berat_badan');
            $table->integer('luas_permukaan_tubuh');
            $table->integer('ID_resep');
            $table->string('nama_obat');
            $table->string('bentuk_sediaan');
            $table->integer('jumlah_obat');
            $table->string('aturan_pakai');
            $table->string('catatan_resep');
            $table->string('dokter_penulis');
            $table->integer('nomor_telepon_seluler');
            $table->date('tanggal_penulisan_resep');
            $table->time('jam_penulisan_resep');
            $table->string('tanda_tangan_dokter');
            $table->string('status_resep');
            $table->string('pengkajian_resep');
    
            

            
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
        Schema::dropIfExists('obat');
    }
};
