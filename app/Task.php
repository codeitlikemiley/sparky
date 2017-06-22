<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table ='tasks';

    protected $fillable = [
        'name',
        'description',
        'link',
        'max_points',
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function subtasks()
    {
        return $this->hasMany('App\SubTask','task_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
