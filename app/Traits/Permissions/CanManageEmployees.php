<?php 

namespace App\Traits\Permissions;

trait CanManageEmployees
{
    public function managedEmployees()
    {
        return $this->hasMany('App\Employee', 'tenant_id', 'id')->select(['id','name','email']);
    }

}