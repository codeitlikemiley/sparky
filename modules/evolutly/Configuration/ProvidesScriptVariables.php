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
            'userId' => self::getTenantID(),
            'employeeId' => self::getEmployeeID(),
            'clientId' => self::getClientID(),
            'state' => self::getState(),
        ];
    }

    protected static function getState()
    {
       return Evolutly::call(InitialFrontendState::class.'@forUser', [Auth::user()]);
    }

    protected static function getClientID()
    {
        return Auth::guard('client')->id();
    }

    protected static function getEmployeeID()
    {
        return Auth::guard('employee')->id();
    }

    protected static function getTenantID()
    {
        return Auth::guard('web')->id();
    }
}
