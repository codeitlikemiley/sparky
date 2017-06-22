<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table ='subtasks';

    public $fillable = [
        'name',
        'assigned_points',
        'priority',
        'video_link',
        'due_date',
    ];

    public $casts = [
        'done' => 'boolean'
    ];

    public $dates = ['created_at', 'updated_at', 'due_date'];

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }
}
