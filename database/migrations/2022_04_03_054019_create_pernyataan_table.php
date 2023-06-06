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
        Schema::create('pernyataan', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('penanggungjawab');
            $table->string('petugas');
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('penanggungjawab')->references('id')->on('penanggungjawab');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pernyataan');
    }
};
