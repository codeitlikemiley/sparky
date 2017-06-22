<?php 

namespace App\Traits\Permissions;

trait CanCreateProjects
{
    // This Trait Needs to Be Added to User and Employee
    // Since a User Can Create a Project
    // and Employee Can Also Create a Project
    public function projects()
    {
        return $this->morphMany('App\Project', 'projectable');
    }
}