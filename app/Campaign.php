<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\CampaignBuilder;

class Campaign extends Model
{
    use CampaignBuilder;
    protected $table ='campaigns';

    protected $fillable = [
        'name',
        'order'
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function tasks()
    {
        return $this->hasMany('App\Task', 'campaign_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
    }
}
