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
        Schema::create('penyakits', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('kode', 10)->index();
            $table->string('name')->index();
            $table->string('note')->nullable();
            $table->string('parent_id', 36)->nullable()->index();
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
        Schema::dropIfExists('penyakits');
    }
};
