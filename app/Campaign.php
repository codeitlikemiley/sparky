<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
