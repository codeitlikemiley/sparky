<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditProject extends BaseController
{
    protected $input;

    protected $message = 'Project Edited!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->input = $request;
    }

    public function __invoke($project)
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $this->editProject($project);
        return response()->json(['message' => $this->message, 'project' => $project], $this->code);
    }

    private function editProject($project)
    {
        if($this->allows($project)){
            $this->addName($project);
            $this->AddClientIfAny($project);
            $this->save($project);
        }
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function allows($project)
    {
        if($project->byTenant()->id != $this->tenant()->id)
        {
            $this->code = 401;
            $this->message = 'UnAuthorized';
            return false;
        }
        return true;
    }

   private function AddName($project)
    {
        
        $project->name = $this->input->project_name;
    }

    private function AddClientIfAny($project)
    {
        if(isset($this->input->client_id['id']))
        {
            $tenant_clients = $this->tenant()->clients->pluck('id')->toArray();
            $client_id = $this->input->client_id['id'];
            if(in_array($client_id,$tenant_clients))
            {
            $project->client_id = $client_id;
            }
        }
    }

    private function save($project)
    {
        $save = $project->save();
        if(!$save){
        $this->message = 'Editing Project Failed';
        $this->code = 404;
        }
    }
}