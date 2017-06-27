<?php

namespace Modules\Employee\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\Controller as BaseController;
use Auth;

class LoginController extends BaseController
{
    public function __construct()
    {
      $this->middleware('guest:employee', ['except' => ['logout']]);
    }

    public function showLoginForm($tenant)
    {
      return view('modules.employee.login',['tenant' => $tenant]);
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (Auth::guard('employee')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('employee.dashboard',['tenant' => $request->username]));
      }

      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect()->url(config('app.url'));
    }
}