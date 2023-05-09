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
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('pasien_id_old')->nullable();
            $table->string('tipe_pasien')->nullable();
            $table->string('gol_darah', '10')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn('pasien_id_old');
            $table->dropColumn('tipe_pasien');
            $table->dropColumn('gol_darah');
        });
    }
};
