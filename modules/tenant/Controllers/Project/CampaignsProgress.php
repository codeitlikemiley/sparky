<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class CampaignsProgress extends BaseController
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

    public function __invoke($tenant,$project)
    {
        $campaigns = $project->campaigns()->get()->toArray();
        return view('project::progress',['campaigns' => $campaigns, 'project' => $project]);
    }
}