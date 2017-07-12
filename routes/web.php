<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
      Route::get('/', 'WelcomeController@show')->name('wildcard_frontend');
    //   Route::get('/login', 'WelcomeController@show')->name('wildcard_frontend.login');
    // Route::get('/', 'DashboardController@index')->name('tenant.dashboard');
});

Route::get('/', 'WelcomeController@show')->name('frontend');

Route::get('/paid', ['middleware' => 'subscribed', function () {
    // Route ONLY for Subscribed User
}]);

Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'HomeController@show')->name('dashboard');
      Route::post('/projects/create', 'Project\CreateProject')->name('tenant.projects.create');
      Route::post('/projects/{projectID}/edit', 'Project\EditProject')->name('tenant.projects.edit');
      Route::post('/projects/{projectID}/campaigns/create', 'Campaign\CreateCampaign')->name('tenant.campaigns.create');
      Route::post('/campaigns/{campaign}/edit', 'Campaign\EditCampaign')->name('tenant.campaigns.edit');
      Route::post('/campaigns/{campaign}/delete', 'Campaign\DeleteCampaign')->name('tenant.campaigns.delete');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('tenant.projects.view');
      Route::post('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('tenant.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('tenant.tasks.view');
  });

  Route::group(['prefix' => '/users'], function () {
      Route::get('/employee', 'User\ShowEmployee')->name('tenant.employees.index');
      Route::get('/client', 'User\ShowClient')->name('tenant.clients.index');
  });
