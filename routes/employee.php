<?php
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
  Route::get('/profile', 'Profile')->name('employee.profile');
  Route::put('/profile', 'UpdateProfile')->name('employee.profile.update');
  Route::put('/profile/upload', 'UploadAvatar')->name('employee.profile.upload');
  // Authentication Routes
  Route::get('/login', 'Auth\LoginController@showLoginForm')->name('employee.login');
  Route::post('/login', 'Auth\LoginController@login')->name('employee.login.submit');
  Route::get('/logout', 'Auth\LoginController@logout')->name('employee.logout');
  // Password reset Routes
  Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('employee.password.email');
  Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('employee.password.request');
  Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('employee.password.reset');
  // Admin Dashboard Route

  Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'DashboardController@index')->name('employee.dashboard');
      // Route::get('/projects/create', 'Project\CreateProject')->name('employee.projects.create');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('employee.projects.view');
      Route::get('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('employee.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('employee.tasks.view');
  });
});



