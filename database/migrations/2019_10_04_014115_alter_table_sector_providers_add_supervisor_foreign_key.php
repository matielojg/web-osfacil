<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSectorProvidersAddSupervisorForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sector_providers', function (Blueprint $table) {
            $table->unsignedBigInteger('supervisor')->nullable();
            $table->foreign('supervisor')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sector_providers', function (Blueprint $table) {
            $table->dropForeign('sector_providers_supervisor_foreign');
            $table->dropColumn('supervisor');
        });
    }
}
