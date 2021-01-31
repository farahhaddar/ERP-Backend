<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    public $timestamps = false;
    
    protected $table="kpis";
    
    protected $fillable=[
        'id','name','employeeId'
    ];
}
