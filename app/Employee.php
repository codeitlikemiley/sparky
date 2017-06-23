<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\EmployeeBuilder;

class Employee extends Model
{
    use EmployeeBuilder;
    
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

}
