<?php

namespace Modules\Evolutly\Providers;

use Modules\Evolutly\Evolutly;
use Illuminate\Support\ServiceProvider;
use Modules\Evolutly\Console\Commands\VersionCommand;

class EvolutlyServiceProvider extends ServiceProvider
{

    public function booted()
    {
        
    }

    public function register()
    {
         if (! class_exists('Evolutly')) {
            class_alias('Modules\Evolutly\Evolutly', 'Evolutly');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                VersionCommand::class,
                // Add Other Console Commands Here
            ]);
        }

        $this->registerServices();
    }

    /**
     * Register the Evolutly services.
     *
     * @return void
     */
    protected function registerServices()
    {

        $services = [
            'Contracts\InitialFrontendState' => 'InitialFrontendState',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('Modules\Evolutly\\'.$key, 'Modules\Evolutly\\'.$value);
        }
    }
}
