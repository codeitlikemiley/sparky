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
        return response()->json(['success' => 'Subtask Deleted.'], 200);

    }

    private function deleteSubtask($subtask)
    {
        $this->authorize($subtask);
        // validate
        $subtask->delete();
    }

    private function authorize($subtask)
    {
        if($subtask->task->campaign->project->ByTenant->id != auth()->user()->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    
}