<?php

namespace Modules\Employee\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class DeleteCampaign extends BaseController
{
    
    protected $input;


    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
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
        return response()->json(['success' => 'Campaign Deleted.'], 200);
    }



    private function authorize($campaign)
    {
        $tenant = User::find(auth()->guard('employee')->user()->tenant_id);
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