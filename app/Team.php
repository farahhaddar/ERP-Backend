<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table="teams";

    public $timestamps = false;

    protected $fillable=[
    'id','name',
    ];
}
