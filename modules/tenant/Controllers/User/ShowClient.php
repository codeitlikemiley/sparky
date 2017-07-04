<?php

namespace Modules\Tenant\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;

class ShowClient extends BaseController
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
        $employees = Client::with('projects')->where('tenant_id',auth()->user()->id)->get();
        return view('tenant::client',['clients' => $clients]);
    }
}