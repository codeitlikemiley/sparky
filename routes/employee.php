<?php
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
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
  Route::get('/dashboard', 'DashboardController@index')->name('employee.dashboard');
  Route::get('/', function ($username) {
    return $username;
    // return redirect()->route('employee.dashboard',['username' => $username->username]);
  });
});



