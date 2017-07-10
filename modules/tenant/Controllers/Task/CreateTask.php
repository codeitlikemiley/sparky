<?php

namespace Modules\Tenant\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Task;

class CreateTask extends BaseController
{
    protected $task;

    protected $input;

    public function __construct(Task $task, Request $request)
    {
        $this->middleware('auth');
        $this->task = $task;
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant=null,$campaign)
    {
        $this->createTask($tenant,$task);
        return response()->json(['success' => 'Task Created.'], 200);

    }

    private function authorize($campaign)
    {
        if(!$tenant)
        {
            $tenant = auth()->user();
        }
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    private function createTask($campaign)
    {
        $this->authorize($tenant,$campaign);
        // validate
        $task = $this->task->fill($this->input);
        $campaign->tasks()->save($task);
    }
}