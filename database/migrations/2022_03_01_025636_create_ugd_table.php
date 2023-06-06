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
            $table->string('pas_id');
            $table->string('pas_td_id');
            $table->string('pen_jaw_id');
            $table->string('peng_id');
            $table->string('bayi_id')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('anamnesa')->nullable();
            $table->string('pemeriksaan_fisik')->nullable();
            $table->string('cara_pembayaran');
            $table->string('asuransi_id');
            $table->string('persetujuan_umum')->nullable();
            $table->string('yg_membuat_pernyataan');
            $table->string('triase');
            $table->string('id_anamnesis');
            $table->string('asesmen_awal');
            $table->string('screnning');
            $table->string('pemeriksaan_psikologis');
            $table->string('riwayat_obat');
            $table->string('pemulangan_pasien');
            $table->string('rencana_rawat');
            $table->string('intruksi_medis');
            $table->string('pemeriksaan_penunjang');
            $table->string('persetujuan_tindakan');
            $table->string('terapi');

            $table->string('triase');
            $table->string('pas_td_id');
            $table->string('id_anamnesis');
            $table->string('asesmen_awal');
            $table->string('screnning');
            $table->string('ppsep');
            $table->string('riw_peng_obat');
            $table->string('rencana_pemulangan');
            $table->string('rencana_rawat_inap');
            $table->string('instruksi_medis');
            $table->string('pemeriksaan_penunjang');
            $table->string('diangnosis');
            $table->string('persetujuan_tindakan');
            $table->string('terapi');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pas_umum_id')->references('id')->on('pasien');
            $table->foreign('pas_td_id')->references('id')->on('pasienb');
            $table->foreign('bbl')->references('id')->on('bayi');
            $table->foreign('triase')->references('id')->on('triase');
            $table->foreign('asuransi_id')->references('id')->on('asuransi');

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
