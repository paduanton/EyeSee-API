<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CriaTabelaUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->string('nome');
//            $table->string('sobrenome');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
//            $table->boolean('deficiente');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
//            $table->timestamp('criado_em')->useCurrent();
//            $table->timestamp('atualizado_em')->useCurrent();;
//            $table->timestamp('deletado_em');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
