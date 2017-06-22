<?php 

namespace App\Traits\Permissions;

trait OwnsByTenant
{
    public function tenant()
    {
        return $this->belongsTo('App\User', 'tenant_id', 'id')->select(['id','name','email']);
    }

}