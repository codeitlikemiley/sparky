<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table ='projects';

    public $fillable = [
        'name'
    ];

    public $casts = [
        'done' => 'boolean'
    ];

    public $dates = ['created_at', 'updated_at'];

    public function tenant()
    {
        return $this->belongsTo('App\User', 'tenant_id', 'id')->select(['id','name','email']);
    }

    public function projectable()
    {
        return $this->morphTo();
    }
}
