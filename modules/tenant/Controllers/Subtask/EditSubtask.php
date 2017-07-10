<?php

namespace Modules\Tenant\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditSubtask extends BaseController
{

    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant=null,$subtask)
    {
        $this->editSubtask($tenant,$subtask);

    }

    private function editSubtask($tenant,$subtask)
    {
        if($this->authorize($tenant,$subtask))
        {
        $subtask->update($this->getInput());
        $this->assignEmployeesIfAny($this->getAuth(),$task,$subtask);
        return response()->json(['success' => 'Subtask Edited.'], 200);
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    private function authorize($tenant,$subtask)
    {
        if(!$tenant)
        {
            $tenant = auth()->user();
        }
        if($subtask->task->campaign->project->ByTenant->id != auth()->user()->id)
        {
            return false;
        }
        return true;
    }

    private function getAuth()
    {
        return auth()->user();
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
        if($employees)
        {
            foreach($employees as $employee){
            $data[$employee] =['project_id' => $project->id];
            }
            $subtask->employees()->sync($data);
        }
        
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
        return $employees;
    }

    
}