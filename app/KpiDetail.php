<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Class KpiDetail extends Model
{
    public $timestamps = false;
    
    protected $table="kpi_details";
    
    protected $fillable=[
        'id','level','date','kpiId'
    ];
}
