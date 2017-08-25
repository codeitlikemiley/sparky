<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class EditSubtask extends BaseController
{

    protected $request;
    
    protected $message = 'Task Edited!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');

        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$subtask)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
        $this->message = 'Failed To Edit Task';
        $this->code = 422;
        return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($task) || $this->createdBy($task)){
            $this->EditSubtask($subtask);
            $this->assignEmployeesIfAny($task,$subtask);
            $this->addUsers($task,$subtask);
            $subtask->save();
            $subtask->employees;
            $employees = $this->getAuth()->employees()->get()->toArray();
            return response()->json(['message' => $this->message, 'subtask' => $subtask, 'employees' => $employees], $this->code);
        }
        $this->message = 'UnAthorized Request!';
        $this->code = 401;
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
        'done' => 'boolean',
        // 'due_date' => 'date|after_or_equal:tomorrow',
        'users.*.name' => 'sometimes|required|max:60',
        'users.*.email' => 'sometimes|required|email',
        'users.*.password' => 'sometimes|required|max:60',
        ];
    }

    private function messages(){
        return [
            'name.required' => 'Define Your Task',
            'name.max' => 'Task Name Too Long Max(30)',
            'points.required' => 'Points is Required',
            'points.min' => 'Minimum Point is 1',
            'done.boolean' => 'Done Should Be A Boolean Value',
            'link.regex' => 'Enter Valid Url',
            'priority.in' => 'Task Value Is Not In Rage 1-5',
            // 'due_date.date' => 'Should Be A Date',
            // 'due_date.after_or_equal' => 'Set Date Tomorrow Or Later',
            'users.*.name.required' => 'Member Requires A Name',
            'users.*.name.max' => 'Name is Too Long Max(60)',
            'users.*.email.required' => 'Member Email is Required',
            'users.*.email.email' => 'Email Provided Is Invalid Format',
            'users.*.password.required' => 'Password is Required',
            'users.*.password.max' => 'Password Exceeded 60 Characters'
        ];
    }

    private function editSubtask($subtask)
    {
        
        $this->addLink($subtask);
        $this->addPriority($subtask);
        $this->addDone($subtask);
        $this->addPoints($subtask);
        $this->addDueDate($subtask);
        $this->addName($subtask);
    }

    private function addName($subtask)
    {
        if(isset($this->request->name)){
            $subtask->name = $this->request->name;
        }
    }

    private function addLink($subtask)
    {
        if(!is_null($this->request->input('link'))){
            $subtask->link = $this->request->input('link');
        }
    }

    private function addPriority($subtask){
        if(isset($this->request->priority)){
            $subtask->priority = $this->request->priority;
            }
    }

    private function addPoints($subtask){
        if(isset($this->request->points)){
            $subtask->points = $this->request->points;
            }
    }

    private function addDueDate($subtask)
    {
        if(isset($this->request->due_date)){
            $subtask->due_date = $this->request->due_date;
        }
    }

    private function addDone($subtask)
    {
        if(isset($this->request->done)){
            $subtask->done = $this->request->done;
        }
    }

    private function addUsers($task,$subtask)
    {
        
        if($this->request->newCollaborator){
            $users_input = $this->request->users;
            for ($i=0; $i < count($users_input); $i++) { 
                if(!$users_input[$i]['name'] || !$users_input[$i]['email'] || !$users_input[$i]['password']){
                    unset($users_input[$i]);
                }
            }
            $project = $task->campaign->project;
            $data = array();
            foreach ($users_input as $user) {
                $employee = Employee::forceCreate($user);
                $this->getAuth()->employees()->save($employee);
                $this->getTenant()->managedEmployees()->save($employee);
                $data[$employee->id] = ['project_id' => $project->id];
            }
            $subtask->employees()->attach($data);
        }
        
    }

    private function assignEmployeesIfAny($task,$subtask)
    {
        $project = $task->campaign->project;
        $employee_lists = $this->hasAssignedEmployees();
        if(count($employee_lists))
        {   
            $data = array();
            foreach($employee_lists as $id){
            $data[$id] =['project_id' => $project->id];
            }
            $subtask->employees()->sync($data);
        }
    }

    private function hasAssignedEmployees()
    {
        $employees = $this->request->assignedEmployees;
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