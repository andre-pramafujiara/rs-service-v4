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
        Schema::create('screening', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('risiko_jatuh');
            $table->string('dicubitus');
            $table->string('batuk');
            $table->string('gizi');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('risiko_jatuh')->references('id')->on('jatuh');
            $table->foreign('dicubitus')->references('id')->on('dicubitus');
            $table->foreign('batuk')->references('id')->on('batuk');
            $table->foreign('gizi')->references('id')->on('gizi');

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
        Schema::dropIfExists('screening');
    }
};
