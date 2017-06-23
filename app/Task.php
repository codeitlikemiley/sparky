<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\TaskBuilder;

class Task extends Model
{
    use TaskBuilder;

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

    protected static $logAttributes = ['name', 'description', 'link', 'maxpoints'];

    public function subtasks()
    {
        return $this->hasMany('App\SubTask','task_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
