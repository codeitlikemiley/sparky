<?php

namespace App\Http\Controllers\Subtask;

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
    public function __invoke($subtask)
    {
        $this->editSubtask($subtask);
    }

    private function editSubtask($subtask)
    {
        if($this->authorize($subtask) || $this->createdBy($subtask))
        {
            $this->validateSubtask($subtask);
            $this->assignEmployeesIfAny($subtask);
            $this->create($subtask);
            
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($subtask)
    {
        
        if($subtask->task->campaign->project->ByTenant()->id != $this->tenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($subtask)
    {
        if($this->tenant()->projects()->find($subtask->task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function tenant()
    {
       return  auth()->user();
    }

    private function validateSubtask($subtask)
    {
        $priority_array = [1,2,3,4,5];
        $this->validate($this->input, [
        'subtask_name' => 'required|max:30',
        'subtask_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'subtask_points' => 'integer|min:0',
        'subtask_priority' => 'in:' . implode(',', $priority_array),
        'subtask_due_date' => 'date_format:d/m/Y|after:tomorrow',
        'subtask_done' => 'boolen',
        ]);
        $subtask->name = $this->input->subtask_name;
        $subtask->link = $this->input->subtask_link;
        $subtask->points = $this->input->subtask_points;
        $subtask->priority = $this->input->subtask_priority;
        $subtask->due_date = $this->input->subtask_due_date;
        $subtask->done = $this->input->subtask_done;
    }

    private function assignEmployeesIfAny($subtask)
    {
        $project = $subtask->task->campaign->project;

        $employee_lists = $this->hasAssignedEmployees();

        if($employee_lists)
        {   
            $data = array();

            foreach($employee_lists as $id)
            {

            $data[$id] =['project_id' => $project->id];

            }

            $this->subtask->employees()->sync($data);
        }
    }

    private function hasAssignedEmployees()
    {
        $employee_ids = $this->input->employees_id;
        $employees = array();
        if(isset($employee_ids))
        {
            $employee_list = $this->tenant()->employees->pluck('id')->toArray();
        
            $employees = array_intersect($employee_list,$employee_ids);
        }
        return $employees;
    }

    private function update($subtask)
    {
        $save = $subtask->save();
        
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Edit Subtask'], 400);
        }
        return response()->json(['success' => 'Subtask Edited!'], 200);
    }

    
}