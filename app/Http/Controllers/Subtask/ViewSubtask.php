<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class ViewSubtask extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($subtask)
    {
        $project = $subtask->task->campaign->project;
        $subtask->employees;
        $task = $subtask->task()->first();
        $client = $task->campaign()->first()->project()->first()->byClient()->first();
        $workers = $this->getWorkers($subtask);
        return view('subtask::view-subtask',['subtask' => $subtask, 'task' => $task, 'project' => $project, 'workers' => $workers, 'client' => $client,]);
    }

    private function getWorkers($subtask){
        $workers = $subtask->task()->first()->campaign()->first()->project()->first()->assignedEmployees()->get();
        $teammates = [];

        if(count($workers)){
            for ($i=0; $i < count($workers); $i++) { 
                $e = Employee::with('assignedprojects.subtasks')->where('id',$workers[$i]['id'])->first();
                array_push($teammates, $e);
            }
        }
        return $teammates;
    }

}