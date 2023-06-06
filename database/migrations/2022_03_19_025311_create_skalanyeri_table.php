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
        Schema::create('skalanyeri', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('nr_scale');
            $table->string('bp_scale');
            $table->string('nip_scale');
            $table->string('va_scale');
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
        Schema::dropIfExists('skalanyeri');
    }
};
