<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenunciasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncias_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_reclamante');
            $table->unsignedBigInteger('id_denunciado');
            $table->unsignedBigInteger('id_post');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('denuncias_users');
    }
}
