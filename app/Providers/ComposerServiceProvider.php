<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Spark\Repositories\NotificationRepository as Notification;

class ComposerServiceProvider extends ServiceProvider
{
    public function __construct(){
	  $this->data = array(
		'appcolor' => 'bg-darkTeal',
	  );
	}
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLatestNotification();
        $this->composeLogin();
        $this->composeAppColor();
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    // Allow Notification in All View!
    private function composeLatestNotification()
    {
        view()->composer(['partials.header.notification_latest'], function($view)
        {
        $notification = new Notification();
        $notification = $notification->recent(auth()->user())->first();
        
        $view->with(compact('notification'));
        });

    }
    private function composeAppColor()
    {
        view()->composer('*', function($view){
            $view->with($this->data);
        });
    }
 

    private function composeLogin()
    {
        view()->composer(['spark::auth.login', 'modules.employee.login', 'modules.client.login', 'modules.employee.forgotpassword', 'modules.client.forgotpassword'], function($view)
        {
        $dir = scandir(base_path('public/images/lock/landscape'));
        foreach ($dir as $key => $value) {
            if(preg_match('/^\.+$/',$value)) {unset($dir[$key]);continue;}
            $tdir[] = $dir[$key];
        }
        $lock_images = $tdir;
        $view->with(compact('lock_images'));
        });
    }
}