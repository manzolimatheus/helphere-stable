<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCampanhas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_campanhas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_campanha');
            $table->decimal('valorDoado', 7,2);
            $table->bigInteger('id_doador');
            $table->timestamps();
        });

        schema::table('payment_campanhas', function (Blueprint $table) {
            
            $table->foreign('id_campanha')->references('id')->on('campanhas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_campanhas');
    }
}
