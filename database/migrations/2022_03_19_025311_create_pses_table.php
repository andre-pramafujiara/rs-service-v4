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
        Schema::create('pses', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('status_psikologi');
            $table->string('sosial_ekonomi');
            $table->string('spiritual');
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
        Schema::dropIfExists('pses');
    }
};
