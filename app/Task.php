<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table ='tasks';

    public $fillable = [
        'name',
        'description',
        'link',
        'max_points',
    ];

    public $casts = [
        'done' => 'boolean'
    ];

    public $dates = ['created_at', 'updated_at'];

    public function subtasks()
    {
        return $this->hasMany('App\SubTask','task_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
