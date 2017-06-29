<?php

namespace Modules\Evolutly;

use Modules\Evolutly\Contracts\InitialFrontendState as Contract;
use Illuminate\Auth\AuthManager;

class InitialFrontendState implements Contract
{
    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }
    public function forUser($user)
    {
        return [
            'user' => $this->projects(),
        ];
    }

    protected function projects()
    {
        return $this->currentUser()->with('projects.campaigns')->find($this->currentUser()->id)->toArray();
    }


    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function currentUser()
    {
        $guard = $this->getUsedGuardOrDefaultDriver();
        return $this->auth->guard($guard)->user();
    }

    protected function getGuardsFromConfig()
    {
        return collect(config('auth.guards'))->keys()->toArray();
    }

    protected function getUsedGuardOrDefaultDriver()
    {
        $guards = $this->getGuardsFromConfig();
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $guard;
            }
        }
        return $auth->getDefaultDriver();
    }

    
}
