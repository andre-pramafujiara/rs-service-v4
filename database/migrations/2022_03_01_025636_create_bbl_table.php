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
        Schema::create('bbl', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_bayi');
            $table->string('nik_ibu_kandung');
            $table->string('no_rm');
            $table->date('tgl_lahir_bayi');
            $table->time('jam_lahir_bayi');
            $table->string('jk_bayi');
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
        Schema::dropIfExists('bbl');
    }
};
