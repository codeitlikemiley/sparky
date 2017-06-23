<?php 

namespace App\Traits\Relationship;

use Spatie\Activitylog\Traits\CausesActivity;

trait CanLogActivities
{
    // Usage:
    // \Auth::user()->activity;
    // \Auth::guard($this->guard)->user()->activity;
    use CausesActivity;
}