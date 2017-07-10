<?php

namespace Modules\Employee\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Campaign;

class CreateCampaign extends BaseController
{
    
    protected $campaign;

    protected $input;


    public function __construct(Campaign $campaign,Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
        $this->campaign = $campaign;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $this->createCampaign($project);
        return response()->json(['success' => 'Campaign Created!'], 200);
    }

    private function createCampaign($project)
    {
        $this->authorize($project);
        $campaign = $this->campaign;
        $campaign->name = $this->input['campaign_name'];
        $campaign->save();
    }

    private function authorize($project)
    {
        if($project->ByTenant->id != auth()->guard('employee')->user()->tenant_id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

}