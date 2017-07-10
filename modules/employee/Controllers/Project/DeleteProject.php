<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class DeleteProject extends BaseController
{
    
    protected $input;


    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant=null,$project)
    {
        
        $this->deleteProject($project);
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



    private function deleteProject($project)
    {
        $employee = $this->canAccessProject($this->authorize($project),$project);
        $project->delete();
    }

}