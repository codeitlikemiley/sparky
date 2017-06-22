<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table ='projects';

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $slugKeyName = 'username';

    public function tenant()
    {
        return $this->belongsTo('App\User', 'tenant_id', 'id')->select(['id','name','email']);
    }

    public function projectable()
    {
        return $this->morphTo();
    }
}
