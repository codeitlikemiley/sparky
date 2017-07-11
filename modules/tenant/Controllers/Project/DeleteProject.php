<?php

namespace Modules\Tenant\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteProject extends BaseController
{

    protected $tenant;
    
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->input = $request->all();
        $this->tenant = auth()->user();
    }

    public function __invoke($tenant,$project)
    {
        $this->deleteProject($project);
    }

    private function deleteProject($project)
    {
        $this->authorize($project);
        $this->delete($project);
    }

    private function authorize($project)
    {
        if($project->ByTenant->id != $this->tenant->id)
        {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    private function delete($project)
    {
        $deleted = $project->delete();
        if($deleted){
            return response()->json(['success' => 'Project Deleted.'], 400);
        }
        response()->json(['error' => 'Project Deletion Failed!.'], 400);
    }

}