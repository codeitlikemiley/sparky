<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditProject extends BaseController
{

    protected $tenant;

    protected $input;

    public function __construct(Request $request, Client $client)
    {
        $this->middleware('auth');
        $this->input = $request->all();
    }

    public function __invoke($tenant=null,$project)
    {
        $this->editProject($project);
    }

    private function editProject($project)
    {
        if($this->authorize($project))
        {
        $this->editName($project);
        $this->AddClientIfAny($project);
        $this->update($project);
        }
        
    }

    private function authorize($project)
    {
        if($project->ByTenant->id != $this->tenant()->id)
        {
            return response()->json(['error' => 'UnAuthorized.'], 401);
        }
    }

    private function editName($project)
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $project->name = $this->input['project_name'];
    }

    private function tenant()
    {
        return auth()->user();
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

    private function update($project)
    {
        $save = $project->save($project);
        if(!$save){
        return response()->json(['success' => 'Editing Project Failed!'], 400);
        }
        return response()->json(['success' => 'Project Editted!'], 200);
    }
}