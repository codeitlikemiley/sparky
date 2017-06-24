<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\CampaignBuilder;

class Subtask extends Model
{
    use CampaignBuilder;

    protected $table ='subtasks';

    protected $fillable = [
        'name',
        'points',
        'priority',
        'link',
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
