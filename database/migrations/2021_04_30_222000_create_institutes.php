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
            $table->string('cnpj', 18)->default('0')->unique();
            $table->string('nome_instituicao', 50);
            $table->unsignedBigInteger('id_criador');
            $table->unsignedBigInteger('id_categoria');
            $table->string('telefone', 14);
            $table->string('email', 100);
            $table->string('municipio', 50)->default('0');
            $table->string('uf', 2)->default('0');
            $table->string('logradouro', 100);
            $table->string('pixKey', 32);
            $table->string('titular', 100);
            $table->string('image');
            $table->string('image_perfil')->nullable();
            $table->text('descricao', 240);
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