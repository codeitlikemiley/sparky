<?php

namespace Modules\Tenant\Controllers\Subtask;

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
    public function __invoke($tenant=null,$subtask)
    {
        $this->deleteSubtask($tenant,$subtask);
        return response()->json(['success' => 'Subtask Deleted.'], 200);

    }

    private function deleteSubtask($tenant,$subtask)
    {
        $this->authorize($tenant,$subtask);
        $subtask->delete();
    }

    private function authorize($tenant,$subtask)
    {
        if(!$tenant)
        {
            $tenant = auth()->user();
        }
        if($subtask->task->campaign->project->ByTenant->id != auth()->user()->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    
}