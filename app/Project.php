<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table ='projects';

    public function tenant()
    {
        return $this->belongsTo('App\User', 'tenant_id', 'id')->select(['id','name','email']);
    }

    public function projectable()
    {
        return $this->morphTo();
    }
}
