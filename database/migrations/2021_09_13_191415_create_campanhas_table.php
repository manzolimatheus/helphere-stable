<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampanhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanhas', function (Blueprint $table) {
            $table->id();
            $table->integer("id_criador");
            $table->string("nome");
            $table->unsignedBigInteger("id_categoria");
            $table->string("telefone");
            $table->string("email");
            $table->string("endereco")->nullable();
            $table->date("data_fim");
            $table->string("img_path");
            $table->string("cidade");
            $table->string("pixKey");
            $table->string("titular");
            $table->text("descricao");
            $table->integer("visualizacoes")->default(0);
            $table->timestamps();
        });

        Schema::table('campanhas', function ($table) {
            $table->foreign('id_categoria')->references('id')->on('category_institutes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campanhas');
    }
}
