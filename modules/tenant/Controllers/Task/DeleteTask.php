<?php

namespace Modules\Tenant\Controllers\Task;

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
    public function __invoke($tenant=null,$task)
    {
        $this->deleteTask($tenant,$task);
        return response()->json(['success' => 'Task Deleted.'], 200);
    }

    private function deleteTask($tenant,$task)
    {
        $this->authorize($tenant,$task);
        $task->delete();
    }

    private function authorize($tenant,$task)
    {
        if(!$tenant){
            $tenant = auth()->user();
        }
        if($task->campaign->project->ByTenant->id != $tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }
}