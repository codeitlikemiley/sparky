<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;

class ToggleSubtask extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Task Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$subtask)
    {
        if($this->allowed($task) || $this->createdBy($task))
        {
            $subtask->done = !$subtask->done;
            $subtask->save();
            $subtask->employees;
            $message = $subtask->done ? 'Subtask Mark As Done' : 'Subtask Undone';
            return response()->json(['subtask' => $subtask,'message' => $message], 200);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function allowed($task)
    {
        
        if($task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->getTenant()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }
    
}