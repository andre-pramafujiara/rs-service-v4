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
        Schema::create('rencanarawat', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('rencana_terapi');
            $table->string('rencana_tindakan');
            $table->integer('rencana_lama_hari_rawat');
            $table->string('indikasi_rawat_inap');
            $table->string('preventif');
            $table->string('paliatif');
            $table->string('kuratif');
            $table->string('rehabilitatif');
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
        Schema::dropIfExists('rencanarawat');
    }
};
