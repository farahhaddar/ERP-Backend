<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_projects', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->bigInteger('teamId')->unsigned();
            $table->bigInteger('projectId')->unsigned();
            $table->foreign('teamId')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('projectId')->references('id')->on('projects')->onDelete('cascade');
            $table->unique(['teamId', 'projectId']);
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_projects');
    }
}
