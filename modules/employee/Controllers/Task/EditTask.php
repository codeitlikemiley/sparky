<?php

namespace Modules\Employee\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class EditTask extends BaseController
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
    public function __invoke($tenant=null,$task)
    {
        $this->editTask($tenant,$task);
        return response()->json(['success' => 'Task Created.'], 200);

    }

    private function editTask($tenant,$task)
    {
        $employee = $this->authorize($tenant,$task);
        $employee = $this->canAccessProject($employee,$task);
        // validate
        $task->update($this->input);
    }

    private function authorize($tenant,$campaign)
    {
        $employee = auth()->guard('employee')->user();
        if(!$tenant)
        {
            $tenant = User::find($employee->tenant_id);
        }
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $employee;
    }

    private function canAccessProject($employee,$task)
    {
        foreach($task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return $employee;
            }
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    
}