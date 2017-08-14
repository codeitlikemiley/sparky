<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;
use App\Employee;

class CreateSubtask extends BaseController
{
    protected $subtask;

    protected $request;

    protected $message = 'Subtask Created!';

    protected $code = '200';

    public function __construct(Subtask $subtask, Request $request)
    {
        $this->middleware('auth');
        $this->subtask = $subtask;
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
        $this->message = 'Failed To Create Subtask';
        $this->code = 422;
        return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($task) || $this->createdBy($task)){
            $this->createSubtask();
            $task->subtasks()->save($this->subtask);
            $this->assignEmployeesIfAny($task);
            $this->addUsers($task);
            $this->subtask->employees;
            return response()->json(['message' => $this->message, 'subtask' => $this->subtask], $this->code);
        }
        $this->code = 401;
        $this->message = 'UnAuthorized Request';
        return response()->json(['message' => $this->message], $this->code);
    }
    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'required|max:30',
        'points' => 'required|min:1',
        'link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'priority' => 'in:1,2,3,4,5',
        'due_date' => 'date|after_or_equal:tomorrow',
        'employees' => 'array',
        'users.*.name' => 'sometimes|required|max:60',
        'users.*.email' => 'sometimes|required|email',
        'users.*.password' => 'sometimes|required|max:60',

        ];
    }

    private function messages(){
        return [
            'name.required' => 'Define Your Subtask',
            'name.max' => 'Subtask Name Too Long Max(30)',
            'points.required' => 'Points is Required',
            'points.min' => 'Minimum Point is 1',
            'link.regex' => 'Enter Valid Url',
            'priority.in' => 'Subtask Value Is Not In Rage 1-5',
            'due_date.date' => 'Should Be A Date',
            'due_date.after_or_equal' => 'Set Date Tomorrow Or Later',
            'employees.array' => 'Subtask Team Should Be An Array',
            'users.*.name' => [
                'required' => 'Member Requires A Name',
                'max'      => 'Name is Too Long Max(60)'
            ],
            'users.*.email' => [
                'required' => 'Member Email is Required',
                'email'      => 'Email Provided Is Invalid Format'
            ],
            'users.*.password' => [
                'required' => 'Password is Required',
                'max'      => 'Password Exceeded 60 Characters'
            ],
        ];
    }
    private function createSubtask()
    {
        
        $this->addLink();
        $this->addPriority();
        $this->addPoints();
        $this->addDueDate();
        $this->addName();
        
    }

    private function addName()
    {
        if(isset($this->request->name)){
            $this->subtask->name = $this->request->name;
        }
    }

    private function addLink()
    {
        if($this->request->input('link')){
            $this->subtask->link = $this->request->input('link');
        }
    }

    private function addPriority(){
        if(isset($this->request->priority)){
            $this->subtask->priority = $this->request->priority;
            }
    }

    private function addPoints(){
        if(isset($this->request->points)){
            $this->subtask->points = $this->request->points;
            }
    }

    private function addDueDate()
    {
        if(isset($this->request->due_date)){
            $this->subtask->due_date = $this->request->due_date;
        }
    }

    

    private function assignEmployeesIfAny($task)
    {
        $project = $task->campaign->project;
        $employee_lists = $this->hasAssignedEmployees();
        if(count($employee_lists))
        {   
            $data = array();
            foreach($employee_lists as $id){
            $data[$id] =['project_id' => $project->id];
            }
            $this->subtask->employees()->sync($data);
        }
    }

    private function addUsers($task)
    {
        $project = $task->campaign->project;
        $data = array();
        foreach ($this->request->users as $user) {
            $employee = Employee::forceCreate($user);
            $this->getAuth()->employees()->save($employee);
            $data[$employee->id] = ['project_id' => $project->id];
        }
        $this->subtask->employees()->attach($data);
    }

    private function hasAssignedEmployees()
    {
        $employees = $this->request->employees;
        $employee_ids = array();
        $selected = array();
        if($employees){
            
            for ($i=0; $i < count($employees); $i++) { 
                array_push($employee_ids,$employees[$i]['id']);
            }
            $employee_list = $this->getTenant()->employees->pluck('id')->toArray();
            $selected = array_intersect($employee_list,$employee_ids);
        }
        return $selected;
    }

    private function allowed($task)
    {
        
        if($task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->getTenant()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    
}