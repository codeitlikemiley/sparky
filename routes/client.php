<?php
Route::group(['domain' => '{username}.'.config('app.domain')], function () {
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
  Route::get('/', 'DashboardController@index')->name('admin.dashboard');
  
});



