<?php

namespace Modules\Evolutly;

use Modules\Evolutly\Contracts\InitialFrontendState as Contract;
use Illuminate\Auth\AuthManager;
use App\Project;
use Route;
use App\Task;
use App\Employee;
use App\User;
use App\Client;

class InitialFrontendState implements Contract
{
    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }
    public function forUser($user)
    {
        // make a method to determine what variable for user we will return
        return $this->getData();
    }

    protected function getData() {
        // we always return a user and a tenant
        $data = array_merge(array(),['user' => $this->currentUser()]);
        $data = array_merge($data,['tenant' => $this->getTenant()]);
        // if we are on the dashboard of the all types of user
        $dashboardRoutes = array("dashboard", "tenant.dashboard", "employee.dashboard", "client.dashboard");
        if (in_array(Route::currentRouteName(), $dashboardRoutes)) {
        $data = array_merge($data,['projects' => $this->projects()]);
        }
        // if we are on the specific project page
        // This Part is Working But WE Will Comment This Out For the Mean Time
        // $projectRoutes = array("employee.projects.view", "client.projects.view", "tenant.projects.view");
        // if (in_array(Route::currentRouteName(), $projectRoutes)) {
        // $data = array_merge($data,['currentProject' => $this->currentProject()]);
        // $data = array_merge($data,['currentProjectFiles' => $this->currentProjectFiles()]);
        // $data = array_merge($data,['currentProjectWorkers' => $this->currentProjectWorkers()]);
        // }
        return $data;
        
    }
    protected function getTenant()
    {
        $user = $this->currentUser();
        if($user instanceOf User){
            return $user; 
        }
        return User::find($user->tenant_id)->select('id','username','name','photo_url')->first();
    }
    // Maybe we can do a eager loading here....
    protected function currentProject()
    {
        // invoke here a controller to get url segment for example {id}
        // then fetch the currentProject
        return Project::find(1);
    }
    protected function currentProjectFiles()
    {
        // $this->currentProject()
        return Task::all();
    }
    protected function currentProjectWorkers()
    {
        // $this->currentProject()
        return Employee::all();
    }

    // default should only be the user
    // for dashboard we add projects
    // fro project we add project , campaigns, files, workers

    protected function projects()
    {
        // if your a tenant fetch all projects with tenant ID
        if(auth()->guard('web'))
        {
            return Project::where('tenant_id', auth()->user()->id)->get()->toArray();
        }
        // Else we Just Fetch All The Project The Current User Has
        return $this->currentUser()->projects()->get()->toArray();
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
