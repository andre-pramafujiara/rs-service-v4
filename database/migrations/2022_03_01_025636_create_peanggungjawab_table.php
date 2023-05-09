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
        Schema::create('penanggungjawab', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_pen_jaw');
            $table->string('alamat_pen_jaw');
            $table->string('provinsi');
            $table->string('kabupaten');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('rw');
            $table->string('rt');
            $table->integer('kode_pos');
            $table->string('negara');
            $table->string('tlp_pen_jaw');
            $table->string('hub_pas');
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
        Schema::dropIfExists('penanggungjawab');
    }
};
