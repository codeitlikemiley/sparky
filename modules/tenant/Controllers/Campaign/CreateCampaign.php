<?php

namespace Modules\Tenant\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Campaign;

class CreateCampaign extends BaseController
{
    
    protected $campaign;

    protected $input;


    public function __construct(Campaign $campaign,Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
        $this->campaign = $campaign;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant=null,$project)
    {
        $this->createCampaign($tenant,$project);
        return response()->json(['success' => 'Project Edited.'], 200);
    }

    private function createCampaign($project)
    {
        $this->authorize($project);
        $campaign = $this->campaign;
        $campaign->name = $this->input['campaign_name'];
        $project->campaigns()->save($campaign);
    }

    private function authorize($tenant,$project)
    {
        if(!$tenant)
        {
            $tenant = auth()->user();
        }
        if($project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

}