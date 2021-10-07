<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_instituicao');
            $table->decimal('valorDoado', 7,2);
            $table->bigInteger('id_doador');
            $table->timestamps();
        });

        schema::table('payments', function (Blueprint $table) {
            
            $table->foreign('id_instituicao')->references('id')->on('institutes');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
