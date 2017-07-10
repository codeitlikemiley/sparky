<?php

namespace App\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteCampaign extends BaseController
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
        
        $this->deleteCampaign($campaign);
        return response()->json(['success' => 'Project Edited.'], 200);
    }



    private function authorize($campaign)
    {
        $tenant = auth()->user();
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        
    }



    private function deleteProject($campaign)
    {
        $this->authorize($campaign);
        $campaign->delete();
    }

}