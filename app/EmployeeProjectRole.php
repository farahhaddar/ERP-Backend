<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeProjectRole extends Model
{
    protected $table="employee_project_roles";
    
    public $timestamps = false;


    protected $fillable=[
        'id','employeeId','projectId','roleId'
    ];
}
