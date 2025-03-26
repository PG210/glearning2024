<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('capsula'); //eliminar la tabla si ya existe

        Schema::create('capsula', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_challenge');
            $table->foreign('id_challenge')->references('id')->on('challenges')->unique();        
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users'); 
            $table->text('respuesta')->nullable();
            $table->text('comentario')->nullable();
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
        Schema::dropIfExists('capsula');
    }
};
