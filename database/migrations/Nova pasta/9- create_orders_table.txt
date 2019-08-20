<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger('user_requester_id');
            $table->unsignedBigInteger('user_responsible_id');
            $table->unsignedBigInteger('sector_requester_id');
            $table->unsignedBigInteger('sector_provider_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('evaluation_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_requester_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_responsible_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sector_requester_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->foreign('sector_provider_id')->references('id')->on('sectors')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
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
