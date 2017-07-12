<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class ShowProject extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $campaigns = $project->campaigns;
        $workers = $project->assignedEmployees;
        return view('project::view',['project' => $project, 'campaigns' => $campaigns, 'workers' => $workers]);
    }
}