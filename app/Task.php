<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\TaskBuilder;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use TaskBuilder, LogsActivity;

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

    protected static $ignoreChangedAttributes = ['updated_at'];

    protected static $logOnlyDirty = true;

    public function subtasks()
    {
        return $this->hasMany('App\SubTask','task_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $guards = collect(config('auth.guards'))->keys()->all();
        foreach ($guards as $guard) {
           if(auth()->guard($guard)->check()){
            $name = auth()->guard($guard)->user()->name;
            break;
           }
        }
        // No user
        if(!$name)return "This model has been {$eventName}";
        // With User
        return "{$eventName} by: {$name}";
    }
}
