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
        Schema::create('keadaanumum', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('tingkat_kesadaran');
            $table->string('vital_sign');
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tingkat_kesadaran')->references('id')->on('tingkatkesadaran');
            $table->foreign('vital_sign')->references('id')->on('vitalsign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keadaanumum');
    }
};
