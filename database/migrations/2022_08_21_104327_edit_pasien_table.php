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
            $table->string('berat')->nullable();
            $table->string('tinggi')->nullable();
            $table->string('email')->nullable();
            $table->string('alergi')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
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
            $table->dropColumn('berat');
            $table->dropColumn('tinggi');
            $table->dropColumn('email');
            $table->dropColumn('alergi');
            $table->dropColumn('pekerjaan_ayah');
        });
    }
};
