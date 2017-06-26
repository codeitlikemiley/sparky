<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Employee\Notifications\ResetPasswordNotification;
use App\Traits\ModelBuilder\EmployeeBuilder;

class Employee extends Authenticatable
{
    use EmployeeBuilder, Notifiable;
    
    protected $table ='employees';

    protected $guard = 'employee';

    protected $fillable = [
        'name',
        'email',
        'photo_url'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
