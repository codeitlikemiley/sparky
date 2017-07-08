<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Project;

class ShowProject extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant,$project)
    {
        // We need to Get the Current Workers
        // We need to Get All Files related to this Project
        $project->load('campaigns.tasks','assignedEmployees')->toArray();
        return view('project::view',['project' => $project, 'tenant' => $tenant]);
    }
}