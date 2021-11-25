<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contato', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('nome', 100);
            $table->string('email', 100);
            $table->string('telefone', 20);  
            $table->string('mensagem', 400);
            $table->string('path', 100);
            $table->string('ip', 50);
            $table->dateTime('data_criacao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contato');
    }
}
