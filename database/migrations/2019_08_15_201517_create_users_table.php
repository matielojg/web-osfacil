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
            $table->string('document')->unique(true);
            $table->string('email')->unique(true);
            $table->string('username')->unique(true);
            $table->string('password');
            $table->string('primary_contact');
            $table->string('secondary_contact')->nullable(true);
            $table->string('photo')->nullable(true);
            $table->enum('function', ['funcionario', 'tecnico', 'supervisor', 'gerente']);
            $table->timestamps();
            $table->softDeletes();

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
