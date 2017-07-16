<?php

namespace App\Traits\Methods;

use Illuminate\Auth\AuthManager;

trait MultiAuth
{
    
    public function getAuth()
    {
        $guard = $this->getUsedGuardOrDefaultDriver();
        return auth()->guard($guard)->user();
    }

    public function getTenant()
    {
        $guard = $this->getUsedGuardOrDefaultDriver();

        $tenant = null;

        switch ($guard) {
        case 'employee':
          $tenant =  User::find(auth()->guard($guard)->user()->tenant_id);
          break;
        case 'client':
          $tenant = User::find(auth()->guard($guard)->user()->tenant_id);
          break;
        default:
          $tenant = User::find(auth()->guard($guard)->user()->id);
          break;
      }
      return $tenant;
    }

    public function getUsedGuardOrDefaultDriver()
    {
        $guards = ['web','employee','client'];
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
        return $auth->getDefaultDriver();
    }
}
