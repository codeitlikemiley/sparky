<?php

namespace App\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditCampaign extends BaseController
{
    
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($campaign)
    {
        
        
        $this->editCampaign($campaign);
        return response()->json(['success' => 'Project Edited.'], 200);
    }

    private function authorize($campaign)
    {
        $tenant = auth()->user();
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $tenant;
        
    }



    private function editCampaign($campaign)
    {
        $tenant = $this->authorize($campaign);
        $campaign->name = $this->input['campaign_name'];
        $campaign->save();
    }
}