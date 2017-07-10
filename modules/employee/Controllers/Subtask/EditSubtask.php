<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class EditSubtask extends BaseController
{
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    public function __invoke($tenant=null,$subtask)
    {
        $this->editSubtask($tenant,$subtask);
    }

    private function editSubtask($tenant,$subtask)
    {
        
        if($this->authorize($tenant,$subtask) && $this->canAccessProject($this->getAuth(),$subtask))
        {
        // validate
        $subtask->update($this->getInput());
        $this->assignEmployeesIfAny($tenant,$task,$subtask);
        return response()->json(['success' => 'Subtask Edited.'], 200);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);

    }

    private function authorize($tenant,$subtask)
    {
        $employee = $this->getAuth();
        if(!$tenant)
        {
            $tenant = User::find($employee->tenant_id);
        }
        if($subtask->task->campaign->project->ByTenant->id != $tenant->id)
        {
            return false;
        }
        return true;
    }

    private function canAccessProject($employee,$subtask)
    {
        foreach($subtask->task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return true;
            }
        }
        return response()->json(['error' => 'UnAuthorized.'], 401);
    }

    private function getAuth()
    {
        return $employee = auth()->guard('employee')->user();
    }


    private function getInput()
    {
       return $this->input->only(['name','points','priority','link','done','due_date']);
    }

    private function assignEmployeesIfAny($tenant,$task,$subtask)
    {
        $project = $this->getProject($task);
        $employees = $this->hasAssignedEmployees($tenant);
        $data = array();
        foreach($employees as $employee){
          $data[$employee] =['project_id' => $project->id];
        }
        $subtask->employees()->sync($data);
    }

    private function getProject($task)
    {
        return $project = $task->campaign->project;
    }

    private function hasAssignedEmployees($tenant)
    {
        $employee_ids = $this->input->employees_id;
        $employees = array();
        if(isset($employee_ids))
        {
            $employee_list = $tenant->employees->pluck('id')->toArray();
        
            $employees = array_intersect($employee_list,$employee_ids);
        }
        // this add the current auth user to the array even if he choose not to assigned it to him.
        $employee = $this->getAuth();
        if(!in_array($employee->id,$employees))
        {
            $employees = array_push($employees,$employee->id);
        }
        return $employees;
    }
}
