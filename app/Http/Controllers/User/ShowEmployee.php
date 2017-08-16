<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class ShowEmployee extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $employees = Employee::with('assignedprojects.subtasks')->where('tenant_id',$this->getTenant()->id)->get();
        return view('tenant::employee',['employees' => $employees]);
    }
}