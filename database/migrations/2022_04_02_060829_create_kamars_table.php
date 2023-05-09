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
        Schema::create('kamars', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('name')->index();
            $table->boolean('status')->default(0);
            $table->boolean('active')->default(0);
            $table->string('kelas_kamar_id');
            $table->string('bangsal_id');
            $table->bigInteger('user_id')->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('kelas_kamar_id')->references('id')->on('kelas_kamar');
            $table->foreign('bangsal_id')->references('id')->on('bangsals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kamars');
    }
};
