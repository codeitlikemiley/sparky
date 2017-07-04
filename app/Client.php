<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Client\Notifications\ResetPasswordNotification;
use App\Traits\ModelBuilder\ClientBuilder;
use Laravel\Spark\HasApiTokens;

class Client extends Authenticatable
{
    use ClientBuilder, Notifiable, HasApiTokens;

    protected $table ='clients';

    protected $guard = 'client';

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

    public function projects()
    {
        return $this->hasMany('App\Project');
    }
}
