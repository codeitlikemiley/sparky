<?php

namespace App\Http\Controllers\Project;

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
    public function __invoke()
    {
        $tenant = auth()->user();
        $this->createProject($tenant);
        return response()->json(['success' => 'Project Created!'], 200);
    }

    private function hasClient($tenant)
    {
        if(isset($this->input['client_id'])){
            return $this->validateClient($tenant);
        }
    }

    private function createProject($tenant)
    {
        $tenant = auth()->user();
        $project = $this->project;
        $project->name = $this->input['project_name'];
        // check if the client id is created by the tenant
        if($client = $this->hasClient($tenant)){
            $project->client_id = $client->id;
        }
        $tenant->projects()->save($project);
    }

    private function validateClient($tenant)
    {
        $client =  $this->getClient();
        if($client->tenant_id === $tenant->id){
            return $client;
        }
        return false;
    }

    private function getClient()
    {
        return $this->client->findOrFail($this->input['client_id']);
    }
}