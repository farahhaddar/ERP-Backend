<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamProject extends Model
{
    protected $table="team_projects";
    
    public $timestamps = false;

    protected $fillable=[
        'id','teamId','projectId'
    ];
}
