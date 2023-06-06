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
        Schema::create('persetujuanpasien', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->boolean('ketentuan_bayar');
            $table->boolean('hak_keewajiban');
            $table->boolean('tata_tertib');
            $table->boolean('terjemah_bahasa');
            $table->boolean('rohaniawan');
            $table->boolean('pelepasan_rahasia');
            $table->boolean('to_penjamin');
            $table->boolean('to_pserta_didik');
            $table->boolean('to_angota_keluarga');
            $table->boolean('to_fasyankes');

            $table->bigInteger('user_id')->index();
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
        Schema::dropIfExists('persetujuanpasien');
    }
};
