<?php

namespace Modules\Employee\Controllers;

use Illuminate\Http\Request;
use Modules\Controller as BaseController;

class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tenant)
    {
        return view('modules.employee.dashboard',['tenant' => $tenant]);
    }
}