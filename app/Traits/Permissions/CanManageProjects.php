<?php 

namespace App\Traits\Permissions;

trait CanManageProjects
{
    public function manageProjects()
    {
        return $this->hasMany('App\Project', 'tenant_id', 'id')->select(['id','name','slug','done']);
    }

}