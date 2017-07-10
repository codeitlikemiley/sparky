<?php

namespace Modules\Tenant\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditTask extends BaseController
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
    public function __invoke($tenant=null,$task)
    {
        $this->editTask($task);
        return response()->json(['success' => 'Task Edited.'], 200);

    }
    private function authorize($tenant,$task)
    {
        if(!$tenant)
        {
            $tenant = auth()->user();
        }
        if($task->campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    private function editTask($task)
    {
        $this->authorize($task);
        // validate
        $task->fill($this->input);
        $task->save();
    }
}