<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;
use App\User;

class EditProject extends BaseController
{
    
    protected $input;

    protected $client;

    public function __construct(Request $request, Client $client)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant=null,$project)
    {
        $this->editProject($project);
        return response()->json(['success' => 'Project Edited.'], 200);
    }



    private function authorize($project)
    {
        $employee = auth()->guard('employee')->user();
        if($project->ByTenant->id != $employee->tenant_id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $employee;        
    }

    private function canAccessProject($employee,$project)
    {
        foreach($project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return $employee;
            }
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }



    private function editProject($project)
    {
        // checks if the project is of the same tenant
        $employee = $this->authorize($project);
        // checks if the project was assigned on the employee
        $employee = $this->canAccessProject($employee,$project);

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