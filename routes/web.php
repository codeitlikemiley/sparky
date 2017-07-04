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

Route::get('/', 'WelcomeController@show')->name('frontend');

Route::get('/paid', ['middleware' => 'subscribed', function () {
    // Route ONLY for Subscribed User
}]);

Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'HomeController@show')->name('dashboard');
      Route::get('/employees', 'User\ShowEmployee')->name('tenant.users.index');
      // Route::get('/projects/create', 'Project\CreateProject')->name('employee.projects.create');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('tenant.projects.view');
      Route::get('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('tenant.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('tenant.tasks.view');
  });
