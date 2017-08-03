<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Evolutly',
        'product' => 'Task Management App',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'admin@evolutly.info';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'admin@evolutly.info'
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe();
        if(isset(request()->username->username)){
            Spark::afterLoginRedirectTo(route('tenant.dashboard',['username' => request()->username->username]));
        }else{
            Spark::afterLoginRedirectTo('/dashboard');
        }
        Spark::plan('BASIC PLAN', 'spark_test_1')
            ->price(10)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('PRO PLAN', 'spark_test_2')
            ->price(30)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::collectBillingAddress();
        
    }
}
