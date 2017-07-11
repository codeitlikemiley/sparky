<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;

class CreateSubtask extends BaseController
{
    protected $subtask;

    protected $input;

    public function __construct(Subtask $subtask, Request $request)
    {
        $this->middleware('auth');
        $this->subtask = $subtask;
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        $this->createSubtask($task);
    }
    private function createSubtask($task)
    {
        if($this->authorize($task) || $this->createdBy($task))
        {
            $this->validateSubtask($task);
            $this->assignEmployeesIfAny($task);
            $this->create($task);
            
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($task)
    {
        
        if($task->campaign->project->ByTenant()->id != $this->tenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->tenant()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function tenant()
    {
       return  auth()->user();
    }

    private function validateSubtask($task)
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
        $this->subtask->name = $this->input->subtask_name;
        $this->subtask->link = $this->input->subtask_link;
        $this->subtask->points = $this->input->subtask_points;
        $this->subtask->priority = $this->input->subtask_priority;
        $this->subtask->due_date = $this->input->subtask_due_date;
        $this->subtask->done = $this->input->subtask_done;
    }




    private function assignEmployeesIfAny($task)
    {
        $project = $task->campaign->project;
        $employee_lists = $this->hasAssignedEmployees();
        if($employee_lists)
        {   
            $data = array();
            foreach($employee_lists as $id){
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

    private function create($task)
    {
        $save = $task->subtasks()->save($this->subtask);
        
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Create Subtask'], 400);
        }
        return response()->json(['success' => 'Subtask Created!'], 200);
    }

    
}