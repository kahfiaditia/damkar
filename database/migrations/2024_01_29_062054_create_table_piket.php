<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePiket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piket', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 15);
            $table->string('deskripsi', 20)->nullable();
            $table->string('status', 1)->nullable();
            $table->unsignedBigInteger('user_created')->nullable();
            $table->foreign('user_created')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated')->nullable();
            $table->foreign('user_updated')->references('id')->on('users');
            $table->unsignedBigInteger('user_deleted')->nullable();
            $table->foreign('user_deleted')->references('id')->on('users');
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
        Schema::dropIfExists('piket');
    }
}
