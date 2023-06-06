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
        Schema::create('membuatpernyataan', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('dokter_memberi_penjelasan');
            $table->string('pasien_keluarga_menerima');
            $table->string('saksi_1');
            $table->string('saksi_2');
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
        Schema::dropIfExists('membuatpernyataan');
    }
};
