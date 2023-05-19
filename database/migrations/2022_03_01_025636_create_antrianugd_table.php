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
        Schema::create('antrianugd', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->date('tgl_periksa');
            $table->integer('urutan_antrian');
            $table->string('status','1');
            $table->integer('id_ugd')->unsigned();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_ugd')->references('id')->on('ugd');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrianugd');
    }
};
