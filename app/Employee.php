<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table="employees";
    
    public $timestamps = false;

    protected $fillable=[
        'id','name' ,'email','phoneNb','image','teamId'
    ];
}
