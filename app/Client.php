<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Client\Notifications\ResetPasswordNotification;
use App\Traits\ModelBuilder\ClientBuilder;

class Client extends Authenticatable
{
    use ClientBuilder, Notifiable;

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
}
