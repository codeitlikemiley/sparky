<?php
  // Update Profile
  Route::get('/profile', 'Profile')->name('client.profile');
  Route::put('/profile', 'UpdateProfile')->name('client.profile.update');
  Route::put('/profile/upload', 'UploadAvatar')->name('client.profile.upload');
  Route::get('/password', 'Password')->name('client.password');
  Route::put('/password', 'ChangePassword')->name('client.password.change');
  // Authentication Routes
  Route::get('/login', 'Auth\LoginController@showLoginForm')->name('client.login');
  Route::post('/login', 'Auth\LoginController@login')->name('client.login.submit');
  Route::get('/logout', 'Auth\LoginController@logout')->name('client.logout');
  // Password reset Routes
  Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('client.password.email');
  Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('client.password.request');
  Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
  Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('client.password.reset');
  // Admin Dashboard Route
  Route::group(['prefix' => '/dashboard'], function () {
      Route::get('/', 'DashboardController@index')->name('client.dashboard');
      Route::get('/projects/{projectID}', 'Project\ShowProject')->name('client.projects.view');
      Route::post('/projects/{projectID}/progress', 'Project\CampaignsProgress')->name('client.projects.progress');
      Route::get('/tasks/{task}', 'Task\ShowTask')->name('client.tasks.view');
  });


