<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\User;
use App\Employee;
use App\Client;
use App\Project;
use App\Campaign;
use App\Task;
use App\Subtask;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        
        Route::bind('username', function ($value) {
        return User::where('username', $value)->first();
        });
        Route::pattern('username', '[a-z0-9_-]{3,16}');

        Route::bind('projectSlug', function ($value) {
        return User::where('slug', $value)->first();
        });
        Route::pattern('projectSlug', '[a-z0-9-]+');

        Route::model('user', User::class);
        Route::pattern('user', '[0-9]+');

        Route::model('employee', Employee::class);
        Route::pattern('employee', '[0-9]+');

        Route::model('client', Client::class);
        Route::pattern('client', '[0-9]+');

        Route::model('projectID', Project::class);
        Route::pattern('projectID', '[0-9]+');

        Route::model('campaign', Campaign::class);
        Route::pattern('campaign', '[0-9]+');

        Route::model('task', Task::class);
        Route::pattern('task', '[0-9]+');

        Route::model('subtask', Subtask::class);
        Route::pattern('subtask', '[0-9]+');

        Route::pattern('id', '[0-9]+');
        Route::pattern('nonwww', '[\/\w\.-]*');
        Route::pattern('subdomain', '^(?!.*(admin|api|www)).*$');
        
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        $this->mapApiRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => ['web', 'hasTeam'],
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
            'middleware' => 'api',
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
