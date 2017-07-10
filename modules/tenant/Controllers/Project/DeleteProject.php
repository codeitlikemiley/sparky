<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteProject extends BaseController
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
    public function __invoke($tenant=null,$project)
    {
        
        $this->deleteProject($tenant,$project);
        return response()->json(['success' => 'Project Edited.'], 200);
    }



    private function authorize($tenant,$project)
    {
        if(!$tenant){
        $tenant = auth()->user();
        }
        if($project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        
    }



    private function deleteProject($tenant,$project)
    {
        $this->authorize($tenant,$project);
        $project->delete();
    }

}