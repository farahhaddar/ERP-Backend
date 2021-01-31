<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKpiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kpi_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('level');
            $table->date('date');
            $table->bigInteger('kpiId')->unsigned();
            $table->foreign('kpiId')->references('id')->on('kpis')->onDelete('cascade');

        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kpi_details');
    }
}
