<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteTask extends BaseController
{
    protected $input;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        $this->deleteTask($task);
        return response()->json(['success' => 'Task Edited.'], 200);
    }

    private function deleteTask($task)
    {
        $this->authorize($task);
        $task->delete();
    }

    private function authorize($task)
    {
        if($task->campaign->project->ByTenant->id != auth()->user()->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}