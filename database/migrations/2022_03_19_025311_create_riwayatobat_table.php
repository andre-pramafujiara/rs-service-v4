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
        Schema::create('riwayatobat', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nama_obat');
            $table->string('dosis');
            $table->string('waktu_penggunaan');
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
        Schema::dropIfExists('riwayatobat');
    }
};
