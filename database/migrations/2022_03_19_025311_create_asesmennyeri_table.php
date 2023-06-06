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
        Schema::create('assesmennyeri', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('lokasi_nyeri');
            $table->string('durasi_nyeri');
            $table->string('penyebab_nyeri');
            $table->string('frekuensi_nyeri');
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
        Schema::dropIfExists('assesmennyeri');
    }
};
