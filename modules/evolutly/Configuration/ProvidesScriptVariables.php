<?php

namespace Modules\Evolutly\Configuration;

use Modules\Evolutly\Evolutly;
use Illuminate\Support\Facades\Auth;
use Modules\Evolutly\Contracts\InitialFrontendState;

trait ProvidesScriptVariables
{
    /**
     * Get the default JavaScript variables for Spark.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'csrfToken' => csrf_token(),
            'env' => config('app.env'),
            'apiDomain' => 'api.'.config('app.domain'),
            'domain' => config('app.domain'),
            'appUrl' => config('app.url'),
            'userId' => Auth::id(),
            'employeeId' => Auth::guard('employee')->id(),
            'clientId' => Auth::guard('client')->id(),
            'state' => Evolutly::call(InitialFrontendState::class.'@forUser', [Auth::user()]),

        ];
    }
}
