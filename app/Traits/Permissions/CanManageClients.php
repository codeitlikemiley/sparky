<?php 

namespace App\Traits\Permissions;

trait CanManageClients
{
    public function managedClients()
    {
        return $this->hasMany('App\Client', 'tenant_id', 'id')->select(['id','name','email']);
    }
}