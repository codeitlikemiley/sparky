<?php

namespace App;

use Laravel\Spark\User as SparkUser;
use App\Traits\ModelBuilder\UserBuilder;

class User extends SparkUser
{
    use UserBuilder;

    protected $table ='users';

    protected $guard = 'web';

    protected $fillable = [
        'name',
        'email',
        'username',
        'photo_url'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
        'tax_rate'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $slugKeyName = 'username';
}
