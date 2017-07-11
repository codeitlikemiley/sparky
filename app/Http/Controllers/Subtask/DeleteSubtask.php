<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteSubtask extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($subtask)
    {
        $this->deleteSubtask($subtask);

    }

    private function deleteSubtask($subtask)
    {
        if($this->authorize($subtask) || $this->createdBy($subtask))
        {
            $this->detachEmployees($subtask);
            $this->delete($task);
            
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($subtask)
    {
        if($subtask->task->campaign->project->ByTenant->id != auth()->user()->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
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

    private function detachEmployees($subtask)
    {
        $subtask->employees()->sync([]);
    }

    private function delete($subtask)
    {
        $deleted = $subtask->delete();
        if(!$deleted)
        {
            return response()->json(['error' => 'Failed To Delete Subtask'], 400);
        }

        return response()->json(['success' => 'Subtask Deleted!'], 200);
    }

    
}