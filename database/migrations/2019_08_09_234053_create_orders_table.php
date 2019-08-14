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
            $table->text('description');
            $table->enum('status', ['ABERTO', 'ATRIBUIDO', 'EM EXECUCAO', 'EXECUTADO', 'SUSPENSO', 'PENDENTE']);
            $table->enum('priority', ['BAIXA', 'MEDIA', 'ALTA', 'CRITICA']);
            $table->unsignedBigInteger('user_requester_id');
            $table->unsignedBigInteger('user_responsible_id');
            $table->unsignedBigInteger('sector_requester_id');
            $table->unsignedBigInteger('sector_provider_id');
            $table->unsignedBigInteger('rating_id');
            $table->unsignedBigInteger('service_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_requester_id')->references('id')->on('users');
            $table->foreign('user_responsible_id')->references('id')->on('users');
            $table->foreign('sector_requester_id')->references('id')->on('sectors');
            $table->foreign('sector_provider_id')->references('id')->on('sectors');
            $table->foreign('rating_id')->references('id')->on('ratings');
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
