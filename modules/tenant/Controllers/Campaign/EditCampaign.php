<?php

namespace Modules\Tenant\Controllers\Campaign;

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
    public function __invoke($tenant=null,$campaign)
    {
        
        
        $this->editCampaign($tenant,$campaign);
        return response()->json(['success' => 'Project Edited.'], 200);
    }

    private function authorize($campaign)
    {
        if(!$tenant){
            $tenant = auth()->user();
        }
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $tenant;
        
    }



    private function editCampaign($tenant,$campaign)
    {
        $tenant = $this->authorize($tenant,$campaign);
        $campaign->name = $this->input['campaign_name'];
        $campaign->save();
    }
}