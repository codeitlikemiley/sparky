<?php

namespace Modules\Tenant\Controllers\Campaign;

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
    public function __invoke($tenant=null,$campaign)
    {
        
        $this->deleteCampaign($campaign);
        return response()->json(['success' => 'Project Edited.'], 200);
    }

    private function authorize($tenant,$campaign)
    {
        if(!$tenant)
        {
        $tenant = auth()->user();
        }
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