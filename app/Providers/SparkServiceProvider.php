<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;
use App\EligibilityChecker;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Client Management Pro',
        'product' => 'Client Management Pro',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = 'admin@clientmanagement.pro';

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        'admin@clientmanagement.pro'
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
        Spark::useStripe()->noCardUpFront()->trialDays(10);
        if(isset(request()->username->username)){
            Spark::afterLoginRedirectTo(route('tenant.dashboard',['username' => request()->username->username]));
        }else{
            Spark::afterLoginRedirectTo('/dashboard');
        }
        Spark::freePlan()
        ->features([
            '3 Projects', 'Unlimited Campaigns', 'Unlimited Task', 'Unlimited Subtasks'
        ]);
        Spark::plan('VIP', 'spark_test_2')
            ->price(30)
            ->features([
                'Unlimited Projects', 'Unlimited Campaigns', 'Unlimited Task', 'Unlimited Subtasks', 'Unlimited Employees', 'Unlimited Clients'
            ]);
        Spark::collectBillingAddress();
        // Spark::checkPlanEligibilityUsing('EligibilityChecker@handle');
        
    }
}
