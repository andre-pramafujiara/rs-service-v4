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
        Schema::create('ugdperawat', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('triase');
            $table->string('anamnesis');
            $table->string('assesmen_nyeri');
            $table->string('tingkat_kesadaran');
            $table->string('vital_sign');
            $table->string('screnning');
            $table->string('pses');
            $table->string('rencana_pemulangan');
            $table->string('rencana_rawat');
            $table->string('instruksi_medis');

            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('triase')->references('id')->on('triase');
            $table->foreign('anamnesis')->references('id')->on('anamnesis');
            $table->foreign('asesmen_nyeri')->references('id')->on('assesmennyeri');
            $table->foreign('screnning')->references('id')->on('screnning');
            $table->foreign('pses')->references('id')->on('pses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ugdperawat');
    }
};
