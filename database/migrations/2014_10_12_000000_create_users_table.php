<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('login');
            $table->string('password');
            $table->enum('function', ['FUNCIONARIO', 'TECNICO', 'SUPERVISOR', 'GERENTE']);
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
