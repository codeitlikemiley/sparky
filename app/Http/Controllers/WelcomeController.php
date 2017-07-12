<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
        if(isset(request()->username))
        {
            $tenant = request()->username;
        }
        return view('welcome',['tenant' =>$tenant]);
    }
}
