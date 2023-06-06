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
        Schema::create('periksafisik', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('gambar_anatomi');
            $table->string('keadaan_umum');
            $table->string('keterangan');
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('keadaan_umum')->references('id')->on('keadaanumum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periksafisik');
    }
};
