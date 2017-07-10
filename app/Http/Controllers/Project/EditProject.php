<?php

namespace App\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;

class EditProject extends BaseController
{
    
    protected $input;

    protected $client;

    public function __construct(Request $request, Client $client)
    {
        $this->middleware('auth');
        $this->input = $request->all();
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        
        
        $this->editProject($project);
        return response()->json(['success' => 'Project Edited.'], 200);
    }



    private function authorize($project)
    {
        $tenant = auth()->user();
        if($project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $tenant;
        
    }



    private function editProject($project)
    {
        $tenant = $this->authorize($project);
        $project->name = $this->input['project_name'];

        if($client = $this->hasClient($tenant)){
            $project->client_id = $client;
        }
        $project->save();
    }

    private function hasClients($tenant)
    {
        if(isset($this->input['client_id'])){
            return $this->validateClient($tenant);
        }
    }

    private function validateClient($tenant)
    {
        $client_id = $this->input['client_id'];
        $client = $this->client->find($client_id);
        if($client->tenant_id === $tenant->id)
        {
            return $client;
        }
        
    }
}