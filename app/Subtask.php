<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $table ='subtasks';

    protected $fillable = [
        'name',
        'assigned_points',
        'priority',
        'video_link',
        'due_date',
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at', 'due_date'];

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }
}
