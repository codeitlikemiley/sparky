<?php 

namespace App\Traits\Permissions;

trait AllowedEmployees
{
    // This Trait Needs to Be Added to Project
    // So We Can Easily Get Array of Employees
    // That Can Access a Certain Project
    public function allowedEmployees()
    {
        return $this->belongsToMany('App\Employee', 'project_employee');
    }
}