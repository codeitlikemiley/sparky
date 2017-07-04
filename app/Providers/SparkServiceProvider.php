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
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        //
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
        Spark::afterLoginRedirectTo('/dashboard');
        Spark::plan('BASIC PLAN', 'spark_test_1')
            ->price(10)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('BASIC PLAN YEARLY', 'spark_test_yearly_1')
            ->price(100)
            ->trialDays(7)
            ->yearly()
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('PRO PLAN', 'spark_test_2')
            ->price(30)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('BASIC PLAN YEARLY', 'spark_test_yearly_2')
            ->price(300)
            ->trialDays(7)
            ->yearly()
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('VIP PLAN', 'spark_test_3')
            ->price(60)
            ->trialDays(7)
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::plan('VIP PLAN YEARLY', 'spark_test_yearly_3')
            ->price(600)
            ->trialDays(7)
            ->yearly()
            ->features([
                'First', 'Second', 'Third'
            ]);
        Spark::promotion('10USDOFF');
        Spark::collectBillingAddress();
        
    }
}
