<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('description');
            $table->enum('status', ['aberto', 'atribuido', 'em execucao', 'executado', 'suspenso', 'pendente']);
            $table->enum('priority', ['baixa', 'media', 'alta', 'critica']);
            $table->enum('type_service', ['corretiva', 'preventiva']);
            $table->date('closed_at')->nullable();
            $table->unsignedBigInteger('requester');
            $table->unsignedBigInteger('responsible')->nullable();
            $table->unsignedBigInteger('sector_requester');
            $table->unsignedBigInteger('sector_provider');
            $table->unsignedBigInteger('evaluation')->nullable();
            $table->unsignedBigInteger('service');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('requester')->references('id')->on('users');
            $table->foreign('responsible')->references('id')->on('users');
            $table->foreign('sector_requester')->references('id')->on('sectors');
            $table->foreign('sector_provider')->references('id')->on('sectors');
            $table->foreign('evaluation')->references('id')->on('evaluations');
            $table->foreign('service')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
