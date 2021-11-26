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
            $table->string("nome", 50);
            $table->unsignedBigInteger("id_categoria");
            $table->string("telefone", 14);
            $table->string("email", 100);
            $table->string("endereco", 100)->nullable();
            $table->date("data_fim");
            $table->string("img_path");
            $table->string("cidade", 50);
            $table->string("pixKey", 32);
            $table->string("titular", 100);
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
