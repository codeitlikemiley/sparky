<?php

namespace Modules\Employee\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Task;
use App\User;

class CreateTask extends BaseController
{
    protected $task;

    protected $input;

    public function __construct(Task $task, Request $request)
    {
        $this->middleware('auth:employee');
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

    private function authorize($tenant,$campaign)
    {
        $employee = auth()->guard('employee')->user();
        if(!$tenant)
        {
            $tenant = User::find($employee->tenant_id);
        }
        if($campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
        return $employee;
    }

    private function canAccessProject($employee,$campaign)
    {
        foreach($campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return $employee;
            }
        }
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    private function createTask($campaign)
    {
        $employee = $this->authorize($tenant,$campaign);
        $employee = $this->canAccessProject($employee,$campaign);
        // validate
        $task = $this->task->fill($this->input);
        $campaign->tasks()->save($task);
    }
}