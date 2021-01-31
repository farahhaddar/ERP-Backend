<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeProjectRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_project_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employeeId')->unsigned();
            $table->bigInteger('projectId')->unsigned();
            $table->bigInteger('roleId')->unsigned();

            $table->foreign('employeeId')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('projectId')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('roleId')->references('id')->on('roles')->onDelete('cascade');
            $table->unique(['roleId', 'projectId','employeeId']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_project_roles');
    }
}
