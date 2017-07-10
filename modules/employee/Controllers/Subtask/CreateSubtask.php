<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;
use App\User;

class CreateSubtask extends BaseController
{
    protected $subtask;

    protected $input;

    public function __construct(Subtask $subtask, Request $request)
    {
        $this->middleware('auth:employee');
        $this->subtask = $subtask;
        $this->input = $request->all();
    }

    public function __invoke($tenant=null,$task)
    {
        $this->createSubtask($tenant,$task);
    }

    private function createSubtask($task)
    {
 
        if($this->authorize($tenant,$task) && $this->canAccessProject($this->getAuth(),$task))
        {
        // validate input
        $subtask = $this->subtask->fill($this->getInput());
        $task->subtasks()->save($subtask);
        $this->assignEmployeesIfAny($tenant,$task,$subtask);
        return response()->json(['success' => 'Subtask Created.'], 200);
        }
        return response()->json(['error' => 'UnAuthorized.'], 401);
        
    }

    private function authorize($tenant,$task)
    {
        $employee = $this->getAuth();
        if(!$tenant)
        {
            $tenant = User::find($employee->tenant_id);
        }
        if($task->campaign->project->ByTenant->id != $tenant->id)
        {
            return false;
        }
        return true;
    }

    private function getAuth()
    {
        return $employee = auth()->guard('employee')->user();
    }

    private function canAccessProject($employee,$task)
    {
        foreach($task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return true;
            }
        }
        return false;
    }

    private function getInput()
    {
       return $this->input->only(['name','points','priority','link','done','due_date']);
    }
    // always assigned the creator of the subtask to the current auth employee
    private function assignEmployeesIfAny($tenant,$task,$subtask)
    {
        $project = $this->getProject($task);
        $employees = $this->hasAssignedEmployees($tenant);
        $data = array();
        foreach($employees as $employee){
          $data[employee] =['project_id' => $project->id];
        }
        $subtask->employees()->sync($data);
    }

    private function getProject($task)
    {
        return $project = $task->campaign->project;
    }
    // always add the creator to the array.
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
