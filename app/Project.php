<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\ProjectBuilder;

class Project extends Model
{
    use ProjectBuilder;

    protected $table ='projects';

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $slugKeyName = 'slug';

    protected $appends = ['campaigns_count'];

    public function campaigns()
    {
        return $this->hasMany('App\Campaign', 'project_id', 'id');
    }

    public function campaignsCount()
    {
        return $this->hasMany('App\Campaign', 'project_id', 'id')->count();
    }

    // Only Return when you Use toArray()
    public function getCampaignsCountAttribute()
    {
        return self::campaignscount();
    }

}
