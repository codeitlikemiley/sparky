<?php
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
Route::group(['prefix' => '/dashboard'], function () {
      // fix this tenant.dashboard being over written by the web route
      Route::get('/', 'DashboardController@index')->name('tenant.dashboard');
      Route::post('/projects/create', 'Project\CreateProject')->name('tenant.projects.create');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('tenant.projects.view');
      Route::post('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('tenant.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('tenant.tasks.view');
  });
});
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
Route::group(['prefix' => '/users'], function () {
      Route::get('/employee', 'User\ShowEmployee')->name('tenant.employees.index');
      Route::get('/client', 'User\ShowClient')->name('tenant.clients.index');
  });
});