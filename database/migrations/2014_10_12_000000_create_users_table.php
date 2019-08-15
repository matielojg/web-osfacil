<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('document')->unique();
            $table->string('email')->unique();
            $table->string('username');
            $table->string('password');
            $table->string('photo');
            $table->enum('function', ['funcionario', 'tecnico', 'supervisor', 'gerente']);
            $table->unsignedBigInteger('sector_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('sector_id')->references('id')->on('sectors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
