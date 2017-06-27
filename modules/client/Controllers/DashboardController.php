<?php

namespace Modules\Client\Controllers;

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
        $this->middleware('auth:client');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tenant)
    {
        return view('modules.client.dashboard');
    }
}