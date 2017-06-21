<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Spark\Repositories\NotificationRepository as Notification;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLatestNotification();
        $this->composeLogin();
        
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
        view()->composer(['partials.header'], function($view)
        {
        $notification = new Notification();
        $notification = $notification->recent(auth()->user())->first();
        
        $view->with(compact('notification'));
        });

    }

    private function composeLogin()
    {
        view()->composer(['spark::auth.login', 'spark::auth.register'], function($view)
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