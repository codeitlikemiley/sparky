<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Project;

class CreateProject extends BaseController
{
    
    protected $tenant;

    protected $project;

    protected $input;

    public function __construct(Project $project,Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
        $this->project = $project;
        
    }

    public function __invoke($tenant)
    {
        $this->createProject();
    }

    private function createProject()
    {
        $this->AddName();
        $this->AddClientIfAny();
        $this->manageProjectsByTenant();
        $this->saveByTenant();
        
    }

    private function AddName()
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $this->project->name = $this->input['project_name'];
    }

    private function AddClientIfAny()
    {
        if(isset($this->input['client_id'])){
            $tenant_clients = $this->tenant()()->clients->pluck('id')->toArray();
            $client_id = $this->input['client_id'];
            if(in_array($client_id,$tenant_clients))
            {
            $this->project->client_id = $client_id;
            }
        }
    }

    private function manageProjectsByTenant()
    {
        $this->tenant()->manageProjects()->save($this->project);
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function saveByTenant()
    {
        $save = $this->tenant()->projects()->save($this->project);
        if(!$save){
        return response()->json(['success' => 'Project Creation Failed.'], 400);
        }
        return response()->json(['success' => 'Project Created!'], 200);
    }
}