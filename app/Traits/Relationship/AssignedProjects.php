<?php 

namespace App\Traits\Relationship;

trait AssignedProjects
{
    // This Trait Needs to Be Added to Employee
    // So We Can Easily Get Array of Projects
    // That An Employee Can Access
    public function assignedProjects()
    {
        return $this->belongsToMany('App\Project', 'project_employee');
    }
}