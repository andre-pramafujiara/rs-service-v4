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
        Schema::create('formugd', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('triase');
            $table->string('peng_id');
            $table->string('anamnesis');
            $table->string('asesmen_awal');
            $table->string('screening');
            $table->string('pses');
            $table->string('riw_peng_obat');
            $table->string('rencana_pemulangan');
            $table->string('rencana_rawat_inap');
            $table->string('instruksi_medis');
            $table->string('pemeriksaan_penunjang');
            $table->string('diagnosis');
            $table->string('persetujuan_tindakan');
            $table->string('terapi');

            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('triase')->references('id')->on('triase');
            $table->foreign('peng_id')->references('id')->on('pengantar');
            $table->foreign('anamnesis')->references('id')->on('anamnesis');
            $table->foreign('asesmen_awal')->references('id')->on('assesmenawal');
            $table->foreign('screnning')->references('id')->on('screnning');
            $table->foreign('pses')->references('id')->on('pses');
            $table->foreign('riw_peng_obat')->references('id')->on('riwayatobat');
            $table->foreign('rencana_pemulangan')->references('id')->on('pemulangan');

            $table->foreign('pemeriksaan_penunjang')->references('id')->on('pemeriksaanpenunjang');
            $table->foreign('diangosis')->references('id')->on('diagnosis');
            $table->foreign('persetujuan_tindakan')->references('id')->on('persetujuantindakan');
            $table->foreign('terapi')->references('id')->on('terapi');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formugd');
    }
};
