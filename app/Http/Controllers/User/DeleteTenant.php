<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;
use App\Notifications\RegistrationWelcomeEmail;
use Carbon\Carbon;
use Laravel\Spark\Spark;

class DeleteTenant extends BaseController
{
    
    protected $message = 'Tenant Account Deleted';

    protected $code = '200';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($tenant)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            
            if($tenant->projects){
                $tenant->projects()->delete();
            }
            // add db constraint on delete Cascade to automatically delete
            $tenant->delete();
            return response()->json(['message' => $this->message, 'user' => $tenant], $this->code);
        }
        $this->code = 401;
        $this->message = 'UnAuthorized Action';
        return response()->json(['message' => $this->message], $this->code);
    }
}