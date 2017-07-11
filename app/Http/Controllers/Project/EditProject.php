<?php

namespace App\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditProject extends BaseController
{
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
    }

    public function __invoke($project)
    {
        $this->editProject($project);
    }

    private function editProject($project)
    {
        $this->authorize($project);
        $this->addName($project);
        $this->AddClientIfAny($project);
        $this->save($project);
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function authorize($project)
    {
        if($project->ByTenant->id != $this->tenant()->id)
        {
            return response()->json(['error' => 'UnAuthorized.'], 401);
        }
    }

   private function AddName($project)
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $project->name = $this->input['project_name'];
    }

    private function AddClientIfAny($project)
    {
        if(isset($this->input['client_id'])){
            $tenant_clients = $this->tenant()->clients->pluck('id')->toArray();
            $client_id = $this->input['client_id'];
            if(in_array($client_id,$tenant_clients))
            {
            $project->client_id = $client_id;
            }
        }
    }

    private function save($project)
    {
        $save = $project->save($project);
        if(!$save){
        return response()->json(['success' => 'Editing Project Failed!'], 400);
        }
        return response()->json(['success' => 'Project Editted!'], 200);
    }
}