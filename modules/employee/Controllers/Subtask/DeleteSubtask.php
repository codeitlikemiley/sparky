<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class DeleteSubtask extends BaseController
{
    protected $subtask;

    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    public function __invoke($tenant=null,$subtask)
    {
        $this->deleteSubtask($tenant,$subtask);
    }

    private function deleteSubtask($tenant,$subtask)
    {
        if($this->authorize($tenant,$subtask) && $this->canAccessProject($this->getAuth(),$subtask))
        {
            // remove all data in employee_subtask
            $subtask->sync([]);
            $subtask->delete();
            return response()->json(['success' => 'Subtask Deleted.'], 200);
        }
        return response()->json(['error' => 'UnAuthorized.'], 401);
    }

    private function authorize($tenant,$subtask)
    {
        $employee = $this->getAuth();
        if(!$tenant)
        {
            $tenant = User::find($employee->tenant_id);
        }
        if($subtask->task->campaign->project->ByTenant->id != $tenant->id)
        {
            return false;
        }
        return true;
    }

    private function getAuth()
    {
        return $employee = auth()->guard('employee')->user();
    }
    // void or unauthorized
    private function canAccessProject($employee,$subtask)
    {
        foreach($subtask->task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return true;
            }
        }
        return false;
    }

}
