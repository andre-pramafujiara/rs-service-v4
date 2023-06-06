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
        Schema::create('batuk', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->boolean('demam');
            $table->boolean('keringat_malam');
            $table->boolean('riwayat_wabah');
            $table->boolean('obat_jangka_panjang');
            $table->boolean('turun_bb');
            $table->integer('user_id')->index();
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
        Schema::dropIfExists('batuk');
    }
};
