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
        Schema::create('assesmenawaldokterugd', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('anamnesis');
            $table->string('pemeriksan_fisik');
            $table->string('pemeriksan_penunjang');
            $table->string('diagnosis');
            $table->string('terapi');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('anamnesis')->references('id')->on('assesmennyeri');
            $table->foreign('pemeriksaan_fisik')->references('id')->on('periksafisik');
            $table->foreign('pemeriksan_penunjang')->references('id')->on('pemeriksaanpenunjang');
            $table->foreign('diagnosis')->references('id')->on('diagnosis');
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
        Schema::dropIfExists('assesmenawaldokterugd');
    }
};
