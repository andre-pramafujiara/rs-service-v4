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
        Schema::create('assesmenawal', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('assesmen_nyeri');
            $table->string('pemeriksan_fisik');
            $table->string('risiko_jatuh');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assesmen_nyeri')->references('id')->on('assesmennyeri');
            $table->foreign('risiko_jatuh')->references('id')->on('jatuh');
            $table->foreign('pemeriksaan_fisik')->references('id')->on('periksafisik');
            
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assesmenawal');
    }
};
