<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj')->default('0')->unique;
            $table->string('nome_instituicao');
            $table->unsignedBigInteger('id_criador');
            $table->unsignedBigInteger('id_categoria');
            $table->string('telefone', 14);
            $table->string('email')->unique;
            $table->string('municipio')->default('0');
            $table->string('uf')->default('0');
            $table->string('logradouro');
            $table->string('pixKey');
            $table->string('titular');
            $table->string('image');
            $table->string('image_perfil')->nullable();
            $table->text('descricao');
            $table->integer('visualizacoes')->default('0');
            $table->timestamps();
        });

        Schema::table('institutes', function ($table) {
            $table->foreign('id_categoria')->references('id')->on('category_institutes')->onDelete('cascade');
            $table->foreign('id_criador')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutes');
    }
}