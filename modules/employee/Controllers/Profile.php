<?php

namespace Modules\Employee\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Profile extends BaseController
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
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant)
    {
        $user = auth()->guard('employee')->user();
        return view('employee::profile',['tenant' => $tenant, 'user' => $user]);
    }
}