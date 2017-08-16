<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class AddEmployee extends BaseController
{

    protected $employee;
    
    protected $request;

    protected $message = 'Adding Teammate Successfull';

    protected $code = '200';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Employee $employee, Request $request)
    {
        $this->middleware('auth:web');
        $this->employee = $employee;
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->message = 'Failed To Create Teammates';
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        $employee = Employee::forceCreate($this->request->only(['name','email', 'password']));
        $employee->projects;
        $this->getAuth()->employees()->save($employee); // Morph
        $this->getTenant()->managedEmployees()->save($employee); // tenant_id
        return response()->json(['message' => $this->message, 'employee' => $employee], $this->code);
        
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'required|max:30',
        'email' => 'required|email|unique:employees,email',
        'password' => 'required|min:6|max:60',
        ];
    }

    private function messages(){
        return [
            'name.required' => 'Name Field is Required',
            'name.max' => 'Name is Too Long (60) Max',
            'email.required' => 'Email is Required',
            'email.email' => 'Email Format Is Invalid',
            'email.unique' => 'Email Is Already taken',
            'password.min' => 'Password Needs to Be At Least (6) Characters',
            'password.max' => 'Password Exceeds 60 Characters',
            'password.required' => 'Password is Required',
        ];
    }
}