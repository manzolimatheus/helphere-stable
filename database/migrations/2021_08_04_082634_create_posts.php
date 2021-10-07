<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_institute');
            $table->unsignedBigInteger('id_poster');
            $table->text('data');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('posts', function ($table) {
            $table->foreign('id_institute')->references('id')->on('institutes')->onDelete('cascade');
            $table->foreign('id_poster')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
