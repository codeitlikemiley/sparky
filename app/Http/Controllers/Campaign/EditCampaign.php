<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Campaign;

class EditCampaign extends BaseController
{
    
    protected $request;

    protected $message = 'Campaign Edited!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($campaign)
    {
         $this->validate($this->request, [
        'campaign_name' => 'required|max:30',
        'campaign_order' => 'int|min:0'
        ]);
        $this->editCampaign($campaign);
        $campaign = Campaign::with('tasks')->where('id',$campaign->id)->first();
        
        return response()->json(['message' => $this->message, 'campaign' => $campaign], $this->code);
        
        
    }

    private function allows($campaign)
    {
        if($campaign->project->byTenant()->id != $this->tenant()->id)
        {
            $this->message = 'UnAuthorized';
            $this->code = 401;
            return false;
        }
        return true;
    }

    private function addName($campaign)
    {
        $campaign->name = $this->request->campaign_name;
    }

    private function addOrder($campaign)
    {
        if(isset($this->request->campaign_order)){
        $campaign->order = $this->request->campaign_order;
        }
    }
    private function tenant()
    {
        return auth()->user();
    }

    private function editCampaign($campaign)
    {
        if($this->allows($campaign)){
            $this->addName($campaign);
            $this->addOrder($campaign);
            $this->save($campaign);
        }
    }

    private function save($campaign)
    {
        $save = $campaign->save();
        if(!$save){
        $this->message = 'Campaign Creation Failed!';
        $this->code = 404;
        }
    }
}