<?php 

namespace App\Traits\Permissions;

trait OwnsByClient
{
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id')->select(['id','name','email']);
    }

}