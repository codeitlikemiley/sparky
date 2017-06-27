<?php

namespace Modules\Employee\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Modules\Controller as BaseController;
use Password;

class ForgotPasswordController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:employee');
    }

    protected function broker()
    {
      return Password::broker('employees');
    }

    public function showLinkRequestForm($tenant)
    {

        return view('modules.employee.forgotpassword',['tenant' => $tenant]);
    }
}