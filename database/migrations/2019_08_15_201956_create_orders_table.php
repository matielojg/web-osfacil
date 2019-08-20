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
            $table->unsignedBigInteger('user_requester_id');
            $table->unsignedBigInteger('user_responsible_id')->nullable();
            $table->unsignedBigInteger('sector_requester_id');
            $table->unsignedBigInteger('sector_provider_id');
            $table->unsignedBigInteger('evaluation_id')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_requester_id')->references('id')->on('users');
            $table->foreign('user_responsible_id')->references('id')->on('users');
            $table->foreign('sector_requester_id')->references('id')->on('sectors');
            $table->foreign('sector_provider_id')->references('id')->on('sectors');
            $table->foreign('evaluation_id')->references('id')->on('evaluations');
            $table->foreign('service_id')->references('id')->on('services');
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
