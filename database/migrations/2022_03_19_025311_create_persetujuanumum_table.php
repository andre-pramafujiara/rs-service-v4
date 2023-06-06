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
        Schema::create('persetujuanumum', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            
            $table->date('tanggal');
            $table->time('jam');;
            $table->string('id_pasien')->nullable();
            $table->string('id_persetujuanpasien');
            $table->string('peryataan');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pasien')->references('id')->on('pasien');
            $table->foreign('id_persetujuanpasien')->references('id')->on('persetujuanpasien');
            $table->foreign('pernyataan')->references('id')->on('pernyataan');
            // $table->foreign('id_perawat')->references('id')->on('perawat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persetujuanumum');
    }
};
