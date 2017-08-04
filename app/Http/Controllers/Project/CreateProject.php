<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Project;

class CreateProject extends BaseController
{
    protected $project;

    protected $request;

    protected $message;

    protected $code = '200';

    public function __construct(Project $project,Request $request)
    {
        $this->middleware(['auth','free-plan']);
        $this->request = $request;
        $this->project = $project;
    }

    public function __invoke()
    {
        $this->validate($this->request, [
        'project_name' => 'required|max:30',
        ]);
        $this->createProject();
        return response()->json(['message' => $this->message, 'project' => $this->project], $this->code);
    }

    private function createProject()
    {
        $this->addName();
        $this->addClientIfAny();
        $this->manageProjectsByTenant();
        $this->saveByTenant();
        
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function addName()
    {
       
        $this->project->name = $this->request->project_name;
    }

    private function addClientIfAny()
    {
        if(isset($this->request->client_id['id']))
        {
            $tenant_clients = $this->tenant()->clients->pluck('id')->toArray();
            $client_id = $this->request->client_id['id'];
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

    private function saveByTenant()
    {
        $save = $this->tenant()->projects()->save($this->project);
        if(!$save){
        $this->message = 'Project Creation Failed';
        }
        $this->message = 'Project Created!';
    }
}