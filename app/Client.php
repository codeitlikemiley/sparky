<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\ClientBuilder;

class Client extends Model
{
    use ClientBuilder;

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

}
