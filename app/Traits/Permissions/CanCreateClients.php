<?php 

namespace App\Traits\Permissions;

trait CanCreateClients
{
    // This Trait Needs to Be Added to User and Employee
    // Since a User as Tenant Can Create a Clients
    // and Employee Can Also Create a Clients
    public function clients()
    {
        return $this->morphMany('App\Client', 'clientable');
    }
}