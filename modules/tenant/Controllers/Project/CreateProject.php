<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Project;
use App\Client;

class CreateProject extends BaseController
{
    
    protected $project;

    protected $input;

    protected $client;

    public function __construct(Project $project,Request $request, Client $client)
    {
        $this->middleware('auth');
        $this->input = $request->all();
        $this->project = $project;
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant)
    {
        $this->createProject($tenant);
        return redirect()->back();
    }

    private function hasClient($tenant)
    {
        if(isset($this->input['client_id'])){
            return $this->validateClient($tenant);
        }
    }

    private function createProject($tenant)
    {
        $user = auth()->user();
        $project = $this->project;
        $project->name = $this->input['project_name'];
        $project->tenant_id = $tenant->id;

        if($this->hasClient($tenant)){
            $client = $this->getClient();
            $client->projects()->save($project);
        }
        $user->projects()->save($project);
    }

    private function validateClient($tenant)
    {
        $client =  $this->getClient();
        if($client->tenant_id === $tenant->id){
            return true;
        }
        return false;
    }

    private function getClient()
    {
        return $this->client->findOrFail($this->input['client_id']);
    }
}