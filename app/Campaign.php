<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table ='campaigns';

    public $fillable = [
        'name',
        'order'
    ];

    public $casts = [
        'done' => 'boolean'
    ];

    public $dates = ['created_at', 'updated_at'];

    public function tasks()
    {
        return $this->hasMany('App\Task', 'campaign_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
}
