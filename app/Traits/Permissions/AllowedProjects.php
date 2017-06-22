<?php 

namespace App\Traits\Permissions;

trait AllowedProjects
{
    // This Trait Needs to Be Added to Employee
    // So We Can Easily Get Array of Projects
    // That An Employee Can Access
    public function allowedProjects()
    {
        return $this->belongsToMany('App\Project', 'project_employee');
    }
}