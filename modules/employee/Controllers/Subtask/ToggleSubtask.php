<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class ToggleSubtask extends BaseController
{
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    public function __invoke($tenant=null,$subtask)
    {
        $this->toogleDone($subtask);
    }

    private function toogleDone($subtask)
    {
       if($this->authorize($subtask) && $this->canAccessProject($subtask))
        {
            $this->toggle($subtask);
            $this->update($subtask);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

   private function authorize($subtask)
    {
        
        if($subtask->task->campaign->project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }

    private function canAccessProject($subtask)
    {
        foreach($subtask->task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy($subtask)
    {
        if($this->employee()->projects()->find($subtask->task->campaign->project->id))
        {
            return true;
        }
        return false;
    }
    private function toggle($subtask)
    {
        $subtask->done = !$subtask->done;
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
